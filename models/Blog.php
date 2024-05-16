<?php

namespace app\models;

use app\core\db\DbModel;

class Blog extends DbModel
{
    public int $id = 0;
    public string $title = '';
    public string $content = '';
    public string $created_at = '';
    public ?string $deleted_at = '';

    public static function tableName(): string
    {
        return 'blogs';
    }

    public function attributes(): array
    {
        return ['title', 'content'];
    }

    public function labels(): array
    {
        return [
            'title' => 'Title',
            'content' => 'Content',
        ];
    }

    public function rules()
    {
        return [
            'title' => [self::RULE_REQUIRED],
            'content' => [self::RULE_REQUIRED],
        ];
    }
}