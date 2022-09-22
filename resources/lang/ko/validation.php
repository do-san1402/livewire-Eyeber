<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'full_name' => '성명 형식 문자열이 아님',
    'nick_name' => '별명 형식 문자열이 아님',
    'nation' => '국가 형식 문자열이 아님',
    'email' => '이메일 형식이 아닌 이메일',
    'birthday' => '생신 형식 날짜가 아님',
    'date_of_joining' => '가입 날짜 형식 날짜가 아님',
    'avatar' => '영상 형식 이미지가 아님',
    'location_detail' => '위치 형식 문자열이 아닙니다.',

    'Please_enter_name' => '이름을 입력하세요',
    'Please_enter_correct_format' => '올바른 형식을 입력하세요.',
    'Please_enter_description' => '설명을 입력하세요',
    'Please_enter_date_end' => '종료 날짜를 입력하세요',
    'Please_enter_date_start' => '시작 날짜를 입력하세요.',
    'Please_enter_mining_settings' => '마이닝 설정을 입력하세요',
    'Please_enter_set_collection_deduction' => '세트 징수 공제를 입력하세요.',
    'Please_enter_nation_id' => '국가를 입력하십시오',
    'Please_enter_video' => '영상을 입력해주세요',
    'Please_enter_advertisement_setting' => '광고 설정을 입력하세요',
    'title' => '제목을 입력하세요',
    'content' => '내용을 입력해주세요',
    'required' => ' :attribute 필드가 필요합니다.',
    'password' => '비밀번호가 틀립니다.',
    'string' => ' :attribute 문자열이어야 합니다.',

    'Please_enter_start_date_that_is_less_than_the_end_date' => "종료 날짜보다 짧은 시작 날짜를 입력하세요.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
       'password' => '비밀번호'
    ],

];
