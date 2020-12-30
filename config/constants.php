<?php
const GENDER = ['MALE' => 'm', 'FEMALE' => 'f'];
const POST_TYPE = ['TEXT' => 'text', 'IMAGE' => 'image', 'VIDEO' => 'video', 'AUDIO' => 'audio', 'GIF' => 'gif'];
const POST_ACTIVITY_TYPE = ['COMMENT' => 'comment', 'LIKE' => 'like', 'DISLIKE' => 'dislike', 'FOLLOW' => 'follow'];
const COMMENT_ACTIVITY_TYPE = ['LIKE' => 'like', 'DISLIKE' => 'dislike'];
return [
    'MALE' => GENDER['MALE'],
    'FEMALE' => GENDER['FEMALE'],
    'POST_TYPE_TEXT' => POST_TYPE['TEXT'],
    'POST_TYPE_IMAGE' => POST_TYPE['IMAGE'],
    'POST_TYPE_VIDEO' => POST_TYPE['VIDEO'],
    'POST_ACTIVITY_LIKE' => POST_ACTIVITY_TYPE['LIKE'],
    'POST_ACTIVITY_DISLIKE' => POST_ACTIVITY_TYPE['DISLIKE'],
    'POST_ACTIVITY_COMMENT' => POST_ACTIVITY_TYPE['COMMENT'],
    'COMMENT_ACTIVITY_LIKE' => POST_ACTIVITY_TYPE['LIKE'],
    'COMMENT_ACTIVITY_DISLIKE' => POST_ACTIVITY_TYPE['DISLIKE'],
    'enums' => [
        'gender' => [GENDER['MALE'], GENDER['FEMALE']],
        'post_type' => [POST_TYPE['TEXT'], POST_TYPE['IMAGE'], POST_TYPE['VIDEO'], POST_TYPE['AUDIO'], POST_TYPE['GIF']],
        'post_activities' => [POST_ACTIVITY_TYPE['COMMENT'], POST_ACTIVITY_TYPE['LIKE'], POST_ACTIVITY_TYPE['DISLIKE']],
        'comment_activities' => [COMMENT_ACTIVITY_TYPE['LIKE'], COMMENT_ACTIVITY_TYPE['DISLIKE']]
    ],
    'paginate_per_page' => env('PAGINATE_PER_PAGE', 15)
];
