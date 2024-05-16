<?php

namespace app\validations\blogs;

use app\models\Blog;

class UpdateBlogValidation extends Blog
{
    public function rules()
    {
        return [
            'id' => [self::RULE_REQUIRED],
            'title' => [self::RULE_REQUIRED],
            'content' => [self::RULE_REQUIRED],
        ];
    }
}
