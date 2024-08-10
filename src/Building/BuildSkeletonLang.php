<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Package\Building;

use Playground\Make\Configuration\Model;

/**
 * \Playground\Make\Package\Building\BuildSkeletonLang
 */
trait BuildSkeletonLang
{
    protected bool $withEn = true;

    protected bool $withTestCoverage = true;

    protected bool $withPhpStan = true;

    protected string $path_lang = '';

    protected string $path_lang_base = '';

    public function setUpLang(): void
    {
        // 'pages.enabled' => 'Revisions are enabled for pages.',
        // 'pages.disabled' => 'Revisions are disabled for pages.',

        // 'snippets.enabled' => 'Revisions are enabled for snippets.',
        // 'snippets.disabled' => 'Revisions are disabled for snippets.',

        $this->searches['lang_models_revisions'] = '';

        $isApi = $this->hasOption('api') && $this->option('api');
        $isResource = $this->hasOption('resource') && $this->option('resource');
        $locale = $this->getLocale();

        $revision = $this->c->revision();

        if (! $locale) {
            dump([
                '__METHOD__' => __METHOD__,
                '$locale' => $locale,
            ]);

            return;
        }

        /**
         * @var array<string, string> $skeletons
         */
        $skeletons = [];

        $setUpLangBase = false;

        if ($revision) {
            $skeletons['lang/en/revisions.php.stub'] = sprintf('lang/%1$s/revisions.php', $locale);
            $setUpLangBase = true;
        }

        if ($skeletons) {
            $this->setUpLang_create_lang();
        }

        if ($setUpLangBase) {
            $this->setUpLang_create_for_lang($locale);
        }

        $models = $this->modelPackage?->models() ?? [];

        $lang_models_revisions = '';

        foreach ($models as $name => $file) {
            $model = new Model($this->readJsonFileAsArray($file));
            $model_slug_plural = $model->model_slug_plural();

            if ($revision
                && ! $model->revision()
                && $model_slug_plural
            ) {
                $lang_models_revisions .= $this->make_lang_revision($model_slug_plural);
            }

            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$name' => $name,
            //     '$file' => $file,
            //     '$model_slug_plural' => $model_slug_plural,
            //     '$lang_models_revisions' => $lang_models_revisions,
            //     // '$model' => $model->apply()->toArray(),
            // ]);
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$lang_models_revisions' => $lang_models_revisions,
        // ]);

        if ($lang_models_revisions) {
            $this->searches['lang_models_revisions'] = $lang_models_revisions;
        }

        foreach ($skeletons as $skeleton => $file) {

            $path_stub = 'package/'.$skeleton;
            $path = $this->resolveStubPath($path_stub);

            $destination = sprintf(
                '%1$s/%2$s',
                dirname($this->folder()),
                $file
            );
            $stub = $this->files->get($path);

            $this->search_and_replace($stub);

            $full_path = $this->laravel->storagePath().$destination;
            $this->files->put($full_path, $stub);

            $this->components->info(sprintf('Language [%s] file %s [%s] created successfully.', $locale, $file, $full_path));
        }
    }

    protected function make_lang_revision(string $names): string
    {
        return <<<PHP_CODE

    '$names.enabled' => 'Revisions are enabled for $names.',
    '$names.disabled' => 'Revisions are disabled for $names.',

PHP_CODE;
    }

    protected function getLocale(): ?string
    {
        $locale = config('playground-make-package.locale');

        if (! $locale || ! is_string($locale)) {
            if (config('app.locale') && is_string(config('app.locale'))) {
                $locale = config('app.locale');
            } else {
                return null;
            }
        }

        // The locale should only be 2 characters; however, we will allow a longer string for now.
        if ((strlen($locale) > 32 || strlen($locale) < 1)) {
            // Prevent junk values from the configuration.
            $locale = null;
        }

        return $locale;
    }

    protected function setUpLang_create_lang(): void
    {
        $this->path_lang = sprintf(
            '%1$s/lang',
            dirname($this->folder()),
        );

        $full_path_lang = $this->laravel->storagePath().$this->path_lang;

        if (is_dir($full_path_lang)) {
            $this->components->info(sprintf('Directory [%s] already exists.', $full_path_lang));

        } else {
            mkdir($full_path_lang, 0755, true);
            if (is_dir($full_path_lang)) {
                $this->components->info(sprintf('Directory [%s] created successfully.', $full_path_lang));
            }
        }
    }

    protected function setUpLang_create_for_lang(string $lang): void
    {
        $this->path_lang_base = sprintf(
            '%1$s/lang/%2$s',
            dirname($this->folder()),
            $lang
        );

        $path_lang_base = $this->laravel->storagePath().$this->path_lang_base;

        if (is_dir($path_lang_base)) {
            $this->components->info(sprintf('Directory [%s] already exists.', $path_lang_base));

        } else {
            mkdir($path_lang_base, 0755, true);
            if (is_dir($path_lang_base)) {
                $this->components->info(sprintf('Directory [%s] created successfully.', $path_lang_base));
            }
        }
    }
}
