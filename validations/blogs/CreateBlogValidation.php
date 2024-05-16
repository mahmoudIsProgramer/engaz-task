<?php

namespace app\validations\blogs;

use app\core\Model;
use app\models\Blog;

class CreateBlogValidation extends Blog
{
    // public string $title = '';
    // public string $content = '';


    public function rules()
    {
        return [
            'title' => [self::RULE_REQUIRED],
            'content' => [self::RULE_REQUIRED],
        ];
    }

    // public function rules(): array
    // {
    //     return [
    //         'title' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 5], [self::RULE_MAX, 'max' => 100]],
    //         'content' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 20]],
    //     ];
    // }

    // public function attributes(): array
    // {
    //     return ['title', 'content'];
    // }

    // public function labels(): array
    // {
    //     return [
    //         'title' => 'Title',
    //         'content' => 'Content',
    //     ];
    // }
}
