<?php

namespace Fomvasss\LaravelTranslatable\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

trait HasTranslations
{
    use HasLanguage;

    protected static function bootHasTranslations()
    {
        static::saved(function ($model) {
            if ($model->{$model->getLangcodeColumn()} && empty($model->{$model->getTranslationUuidColumn()})) {
                $model->{$model->getTranslationUuidColumn()} = Str::uuid();
                $model->save();
            }
        });
    }

    /**
     * @return string
     */
    public function getTranslationUuidColumn(): string
    {
        return config('translatable.db.columns.translation_uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(static::class, $this->getTranslationUuidColumn(), $this->getTranslationUuidColumn());
    }

    public function saveTranslatable(string $langcode, ?string $uuid = null)
    {
        $this->setAttribute($this->getLangcodeColumn(), $langcode);
        if ($uuid) {
            $this->setAttribute($this->getTranslationUuidColumn(), $uuid);
        }

        return $this->save();
    }

    /**
     * @return Collection
     */
    public function getTranslationList(): Collection
    {
        $languages = config('translatable.languages', []);
        $translations = $this->translations;
        $result = new Collection();

        foreach ($languages as $langcode => $language) {
            $model = $translations->where($this->getLangcodeColumn(), $langcode)->first();
            $result->push([
                'model_key' => optional($model)->{$this->getKeyName()},
                'model_type' => Str::snake(class_basename(static::class)),
                'translation_uuid' => optional($model)->{$this->getTranslationUuidColumn()},
                'langcode' => $langcode,
                'language' => $language,
                'status' => $this->getTranslationStatus($langcode, $model)
            ]);
        }

        return $result;
    }

    /**
     * @param string $langcode
     * @param null $model
     * @return string
     */
    protected function getTranslationStatus(string $langcode, $model = null): string
    {
        if (empty($model)) {
            return 'empty';
        }

        if ($this->{$this->getLangcodeColumn()} === $langcode) {
            return 'current';
        }

        return 'translation';
    }
}