<?php

namespace Fomvasss\LaravelTranslatable\Traits;

use Illuminate\Support\Facades\App;

trait HasLanguage
{
    /**
     * @return string
     */
    public function getLangcodeColumn(): string
    {
        return config('translatable.db.columns.langcode');
    }

    /**
     * @param $query
     * @param null|string|array $langcode
     * @return mixed
     */
    public function scopeByLang($query, $langcode = null)
    {
        $langcode = $langcode ?: App::getLocale();

        if (is_array($langcode) && count($langcode)) {
            return $query->whereIn($this->getLangcodeColumn(), $langcode)
                ->orWhereNull($this->getLangcodeColumn());
        }

        $query->where($this->getLangcodeColumn(), $langcode)
            ->orWhereNull($this->getLangcodeColumn());
    }
}