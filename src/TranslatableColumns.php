<?php

namespace Fomvasss\LaravelTranslatable;

use Illuminate\Database\Schema\Blueprint;

class TranslatableColumns
{
    /**
     * Add default nested set columns to the table. Also create an index.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public static function columns(Blueprint $table)
    {
        $table->string(config('translatable.db.columns.langcode'))->nullable();
        $table->uuid(config('translatable.db.columns.translation_uuid'))->nullable();

        $table->index(static::getDefaultColumns());
    }

    /**
     * Drop Translatable columns.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public static function dropColumns(Blueprint $table)
    {
        $columns = static::getDefaultColumns();

        $table->dropIndex($columns);
        $table->dropColumn($columns);
    }

    /**
     * Get a list of default columns.
     *
     * @return array
     */
    public static function getDefaultColumns()
    {
        return [
            config('translatable.db.columns.langcode'),
            config('translatable.db.columns.translation_uuid'),
        ];
    }
}