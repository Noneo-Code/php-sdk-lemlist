<?php

declare(strict_types=1);

namespace Noneo\Sdk\Lemlist\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Sans `#[\SensitiveParameter]`, un secret passé en argument apparaît en clair
 * dans toute trace qui conserve ses arguments — et donc dans Sentry, Bugsink
 * et les journaux applicatifs. Ce test relit `src/` et impose l'attribut sur
 * tout paramètre dont le nom annonce un secret : la clé d'API de la façade
 * comme les mots de passe SMTP des endpoints générés.
 */
final class SensitiveParametersTest extends TestCase
{
    private const string SECRET_NAME_PATTERN = '/password|secret|token|api_?key|credential|authenticator/i';

    public function testEverySecretBearingParameterIsMarkedSensitive(): void
    {
        $offenders = [];
        $marked = 0;

        foreach ($this->sdkMethods() as [$class, $method]) {
            foreach ($method->getParameters() as $parameter) {
                if (1 !== preg_match(self::SECRET_NAME_PATTERN, $parameter->getName())) {
                    continue;
                }

                if ([] === $parameter->getAttributes(\SensitiveParameter::class)) {
                    $offenders[] = sprintf('%s::%s($%s)', $class, $method->getName(), $parameter->getName());
                } else {
                    ++$marked;
                }
            }
        }

        self::assertSame([], $offenders, sprintf(
            "Ces paramètres portent un secret sans #[\\SensitiveParameter] :\n- %s",
            implode("\n- ", $offenders),
        ));
        // La façade, le connecteur, et au moins un endpoint généré.
        self::assertGreaterThan(3, $marked);
    }

    /**
     * @return \Generator<int, array{class-string, \ReflectionMethod}>
     */
    private function sdkMethods(): \Generator
    {
        $src = realpath(__DIR__.'/../src');
        self::assertIsString($src);

        /** @var iterable<\SplFileInfo> $files */
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($src));

        foreach ($files as $file) {
            if ('php' !== $file->getExtension()) {
                continue;
            }

            $relative = substr($file->getPathname(), strlen($src) + 1, -4);
            /** @var class-string $class */
            $class = 'Noneo\\Sdk\\Lemlist\\'.str_replace(\DIRECTORY_SEPARATOR, '\\', $relative);

            if (!class_exists($class) && !interface_exists($class) && !trait_exists($class)) {
                continue;
            }

            foreach ((new \ReflectionClass($class))->getMethods() as $method) {
                // Une méthode héritée de Saloon vit dans `vendor/` : nous ne
                // pouvons pas l'annoter.
                if (str_starts_with((string) $method->getFileName(), $src)) {
                    yield [$class, $method];
                }
            }
        }
    }
}
