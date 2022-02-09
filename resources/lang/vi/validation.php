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

    'accepted' => ':attribute phải được chấp nhận.',
    'accepted_if' => ':attribute phải được chấp nhận khi :other là :value.',
    'active_url' => ':attribute không phải URL hợp lệ.',
    'after' => ':attribute phải là ngày sau ngày :date.',
    'after_or_equal' => ':attribute phải là ngày sau hoặc là ngày :date.',
    'alpha' => ':attribute chỉ được chứa chữ cái.',
    'alpha_dash' => ':attribute chỉ được chứa chữ cái, số, gạch ngang và gạch dưới.',
    'alpha_num' => ':attribute chỉ được chứa chữ cái và số.',
    'array' => ':attribute phải là array.',
    'before' => ':attribute phải là ngày trước ngày :date.',
    'before_or_equal' => ':attribute phải là ngày trước ngày hoặc là ngày :date.',
    'between' => [
        'numeric' => ':attribute phải trong khoảng :min và :max.',
        'file' => ':attribute phải trong khoảng :min và :max kilobytes.',
        'string' => ':attribute phải trong khoảng :min và :max kí tự.',
        'array' => ':attribute phải có khoảng :min và :max phần tử.',
    ],
    'boolean' => ':attribute phải là true hoặc false.',
    'confirmed' => ':attribute xác thực không khớp.',
    'current_password' => 'mật khẩu không đúng.',
    'date' => ':attribute không phải ngày hợp lệ.',
    'date_equals' => ':attribute phải là ngày :date.',
    'date_format' => ':attribute không phù hợp với định dạng :format.',
    'different' => ':attribute and :other must be different.',
    'digits' => ':attribute phải là :digits digits.',
    'digits_between' => ':attribute phải trong khoảng :min và :max digits.',
    'dimensions' => ':attribute có kích thước hình ảnh không hợp lệ.',
    'distinct' => ':attribute có giá trị trùng lặp.',
    'email' => ':attribute phải là một địa chỉ email hợp lệ.',
    'ends_with' => ':attribute phải kết thúc bằng một trong những điều sau: :values.',
    'exists' => ':attribute đã chọn không hợp lệ.',
    'file' => ':attribute phải là 1 file.',
    'filled' => ':attribute phải có giá trị.',
    'gt' => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file' => ':attribute phải lớn hơn :value kilobytes.',
        'string' => ':attribute phải lớn hơn :value kí tự.',
        'array' => ':attribute phải có hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải lớn hơn hoặc bằng :value kí tự.',
        'array' => ':attribute phải có :value phần tử trở lên.',
    ],
    'image' => ':attribute phải là ảnh.',
    'in' => ':attribute đã chọn không hợp lệ.',
    'in_array' => ':attribute không tồn tại trong :other.',
    'integer' => ' :attribute phải là số nguyên.',
    'ip' => ' :attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4' => ' :attribute phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6' => ' :attribute phải là một địa chỉ IPv6 hợp lệ.',
    'json' => ' :attribute phải là chuỗi JSON.',
    'lt' => [
        'numeric' => ' :attribute phải ít hơn :value.',
        'file' => ' :attribute phải ít hơn :value kilobytes.',
        'string' => ' :attribute phải ít hơn :value kí tự.',
        'array' => ' :attribute phải có ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => ' :attribute phải ít hơn hoặc bằng :value.',
        'file' => ' :attribute phải ít hơn hoặc bằng :value kilobytes.',
        'string' => ' :attribute phải ít hơn hoặc bằng :value kí tự.',
        'array' => ' :attribute không được nhiều hơn :value phần tử.',
    ],
    'max' => [
        'numeric' => ' :attribute không được nhiều hơn :max.',
        'file' => ' :attribute không được nhiều hơn :max kilobytes.',
        'string' => ' :attribute không được nhiều hơn :max kí tự.',
        'array' => ' :attribute không được nhiều hơn :max phần tử.',
    ],
    'mimes' => ' :attribute phải là file loại: :values.',
    'mimetypes' => ' :attribute phải là file loại: :values.',
    'min' => [
        'numeric' => ' :attribute phải ít nhất là :min.',
        'file' => ' :attribute phải ít nhất là :min kilobytes.',
        'string' => ' :attribute phải ít nhất là :min kí tự.',
        'array' => ' :attribute  phải ít nhất là :min phần tử.',
    ],
    'multiple_of' => ' :attribute phải là bội số :value.',
    'not_in' => '  :attribute đã chọn không hợp lệ.',
    'not_regex' => ' :attribute định dạng không hợp lệ.',
    'numeric' => ' :attribute phải là 1 số.',
    'password' => ' password không đúng.',
    'present' => ' :attribute phải có mặt.',
    'regex' => ' :attribute định dạng không hợp lệ.',
    'required' => ' :attribute không được để trống.',
    'required_if' => ' :attribute được yêu cầu khi :other là :value.',
    'required_unless' => ':attribute được yêu cầu unless :other is in :values.',
    'required_with' => ':attribute được yêu cầu khi :values có mặt.',
    'required_with_all' => ':attribute được yêu cầu khi :values có mặt.',
    'required_without' => ':attribute được yêu cầu khi :values không có mặt.',
    'required_without_all' => ':attribute được yêu cầu khi không có :values có mặt',
    'prohibited' => ':attribute bị cấm.',
    'prohibited_if' => ':attribute bị cấm khi :other là :value.',
    'prohibited_unless' => ':attribute bị cấm trừ khi :other nằm trong :values.',
    'same' => ':attribute và :other phải khớp nhau.',
    'size' => [
        'numeric' => ':attribute phải là :size.',
        'file' => ':attribute phải là :size kilobytes.',
        'string' => ':attribute phải là :size kí tự.',
        'array' => ':attribute phải chứa :size phần tử.',
    ],
    'starts_with' => ':attribute phải bắt đầu bằng một trong những điều sau: :values.',
    'string' => ':attribute phải là một chuỗi.',
    'timezone' => ':attribute phải là múi giờ hợp lệ.',
    'unique' => ':attribute đã tồn tại',
    'uploaded' => ':attribute không tải lên được.',
    'url' => ':attribute phải là một URL hợp lệ',
    'uuid' => ':attribute phải là một UUID hợp lệ.',

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
        'title' => 'Tên sách',
        'number_of_page' => 'Số trang',
        'published_date' => 'Ngày xuất bản',
        'author' => 'Tên tác giả',
        'image' => 'Ảnh',
    ],

];
