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

    'accepted' => ' :attribute phải được xác nhận',
    'active_url' => ' :attribute phải có kiểu url',
    'after' => ' :attribute phải là một ngày sau :date.',
    'after_or_equal' => ' :attribute phải là một ngày sau hoặc bằng :date.',
    'alpha' => ' :attribute chỉ có thể chứa các chữ cái',
    'alpha_dash' => ' :attribute chỉ có thể chứa chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
    'alpha_num' => ' :attribute chỉ có thể chứa chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
    'array' => ' :attribute phải có kiểu giá trị mảng',
    'before' => ' :attribute phải là một ngày trước đó :date.',
    'before_or_equal' => ' :attribute phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => ' :attribute phải ở giữa :min và :max.',
        'file' => ' :attribute phải ở giữa :min và :max kilobytes.',
        'string' => ' :attribute phải ở giữa :min và :max characters.',
        'array' => ' :attribute must have between :min và :max items.',
    ],
    'boolean' => ' :attribute trường phải có giá trị đúng hoặc sai',
    'confirmed' => ' :attribute xác nhận không khớp.',
    'date' => ' :attribute phải có kiểu là ngày tháng năm',
    'date_equals' => ' :attribute phải là một ngày bằng :date.',
    'date_format' => ' :attribute không khớp với định dạng :format.',
    'different' => ' :attribute và :other phải khác nhau.',
    'digits' => ' :attribute phải là trên  :digits kí tự.',
    'digits_between' => ' :attribute phải là ở giữa :min và :max kí tự.',
    'dimensions' => ' :attribute có kích thước hình ảnh không hợp lệ',
    'distinct' => ' :attribute giá trị này đã bị trùng lặp.',
    'email' => ' :attribute phải là địa chỉ email.',
    'ends_with' => ' :attribute phài là cuối với 1 của những điều sau đây: :values.',
    'exists' => ' selected :attribute không hợp lệ.',
    'file' => ' :attribute phải là một tệp.',
    'filled' => ' :attribute trường này phải có giá trị.',
    'gt' => [
        'numeric' => ' :attribute phải lớn hơn :value.',
        'file' => ' :attribute phải lớn hơn :value kilobytes.',
        'string' => ' :attribute phải lớn hơn :value characters.',
        'array' => ' :attribute phải lớn hơn :value items.',
    ],
    'gte' => [
        'numeric' => ' :attribute phải lớn hơn hoặc bằng :value.',
        'file' => ' :attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => ' :attribute phải lớn hơn hoặc bằng :value characters.',
        'array' => ' :attribute phải là :value items or more.',
    ],
    'image' => ' :attribute phải là một cái ảnh.',
    'in' => ' đã chọn :attribute là không hợp lệ.',
    'in_array' => ' :attribute trường này không tồn tại :other.',
    'integer' => ' :attribute trường này phải có kiểusố nguyên.',
    'ip' => ' :attribute phải là địa chỉ IP .',
    'ipv4' => ' :attribute phải là địa chỉ IPv4 .',
    'ipv6' => ' :attribute phải là địa chỉ IPv6 .',
    'json' => ' :attribute phải là kiểu dữ liệu JSON .',
    'lt' => [
        'numeric' => ' :attribute phải nhỏ hơn :value.',
        'file' => ' :attribute phải nhỏ hơn :value kilobytes.',
        'string' => ' :attribute phải nhỏ hơn :value characters.',
        'array' => ' :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => ' :attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => ' :attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'string' => ' :attribute phải nhỏ hơn hoặc bằng :value characters.',
        'array' => ' :attribute không được có nhiều hơn :value items.',
    ],
    'max' => [
        'numeric' => ' :attribute không được có nhiều hơn :max.',
        'file' => ' :attribute không được có nhiều hơn :max kilobytes.',
        'string' => ' :attribute không được có nhiều hơn :max characters.',
        'array' => ' :attribute không được có nhiều hơn :max items.',
    ],
    'mimes' => ' :attribute phải là một tệp của kiểu dữ liệu: :values.',
    'mimetypes' => ' :attribute phải là một tệp của kiểu dữ liệu: :values.',
    'min' => [
        'numeric' => ' :attribute ít nhất phải :min.',
        'file' => ' :attribute ít nhất phải :min kilobytes.',
        'string' => ' :attribute ít nhất phải :min characters.',
        'array' => ' :attributeít nhất phải :min items.',
    ],
    'multiple_of' => ' :attribute phải là bội số của :value.',
    'not_in' => ' đã chọn :attribute không hợp lệ.',
    'not_regex' => ' :attribute định dạng không hợp lệ.',
    'numeric' => ' :attribute phải là kiểu dữ liệu số.',
    'password' => ' password không đúng.',
    'present' => ' :attribute field must be present.',
    'regex' => ' :attribute định dạng không đúng.',
    'required' => ' :attribute trường này phải bắt buộc.',
    'required_if' => ' :attribute trường này phải bắt buộc khi :other là :value.',
    'required_unless' => ' :attribute trường này phải bắt buộc trừ khi :other là trong :values.',
    'required_with' => ' :attribute trường này phải bắt buộc khi :values có mặt.',
    'required_with_all' => ' :attribute trường này phải bắt buộc khi :values đều có mặt.',
    'required_without' => ' :attribute trường này phải bắt buộc khi :values không có mặt.',
    'required_without_all' => ' :attribute trường này phải bắt buộc khi none of :values đều có mặt.',
    'same' => ' :attribute và :other phải phù hợp.',
    'size' => [
        'numeric' => ' :attribute phải là :size.',
        'file' => ' :attribute phải là :size kilobytes.',
        'string' => ' :attribute phải là :size characters.',
        'array' => ' :attribute phải chứa :size items.',
    ],
    'starts_with' => ' :attribute phải bắt với một trong những điều sau đây: :values.',
    'string' => ' :attribute phải là 1 chuỗi.',
    'timezone' => ' :attribute phải là 1 múi giờ.',
    'unique' => ' :attribute đã tồn tài giá trị này.',
    'uploaded' => ' :attribute không tải lên được.',
    'url' => ' :attribute định dạng không hợp lệ.',
    'uuid' => ' :attribute phải là một UUID hợp lệ.',


    'full_name' => 'tên của bạn phải có định dạng là chuỗi',
    'nick_name' => 'tên của bạn phải có định dạng là chuỗi',
    'nation' => 'bạn chưa chọn đất nước của bạn',
    'birthday' => 'ngày sinh nhật phải có kiểu ngày tháng năm',
    'date_of_joining' => 'ngày gia nhập phải có',
    'avatar' => 'phải có định dạng kiểu ảnh',
    'location_detail' => 'ví trí phải có kiểu dữ liệu chuỗi',
    
    'Please_enter_name' => 'làm ơn nhập tên',
    'Please_enter_correct_format' => 'làm ơn nhập đúng định dạng',
    'Please_enter_description' => 'làm ơn nhập mô tả',
    'Please_enter_date_end' => 'làm ơn nhập ngày cuối',
    'Please_enter_date_start' => 'làm ơn nhập ngày bắt đầu',
    'Please_enter_mining_settings' => 'làm ơn cài đặt khai thác',
    'Please_enter_set_collection_deduction' => 'Vui lòng nhập quy định khấu trừ bộ sưu tập',
    'Please_enter_nation_id' => 'phải chọn đất nước của bạn đang sống',
    'Please_enter_video' => 'phải nhập video',
    'Please_enter_advertisement_setting' => 'Vui lòng nhập cài đặt quảng cáo',
    'title' => 'phải nhập tiêu đề',
    'content' => 'phải nhập  nội dung',
    
    'Please_enter_start_date_that_is_less_than_the_end_date' => "phải nhập ngày bắt đầu thấp hơn ngày cuối",
    






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
    |  following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        
    ],

];
