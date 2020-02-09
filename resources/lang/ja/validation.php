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
    'accepted' => ':attributeを受け入れる必要があります。',
    'active_url' => ':attributeは有効なURLではありません。',
    'after' => ':attributeは:dateより後の日付でなければなりません。',
    'after_or_equal' => ':attributeは、:date以降の日付でなければなりません。',
    'alpha' => ':attributeには文字のみを含めることができます。',
    'alpha_dash' => ':attributeには、文字、数字、ダッシュ、アンダースコアのみを含めることができます。',
    'alpha_num' => ':attributeには文字と数字のみを含めることができます。',
    'array' => ':attributeは配列でなければなりません。',
    'before' => ':attributeは:dateより前の日付でなければなりません。',
    'before_or_equal' => ':attributeは、:date以前の日付でなければなりません。',
    'between' => [
        'numeric' => ':attributeは:minと:maxの間でなければなりません。',
        'file' => ':attributeは:minから:maxキロバイトの間になければなりません。',
        'string' => ':attributeは:min〜:max文字の間になければなりません。',
        'array' => ':attributeには:minから:maxまでのアイテムが必要です。',
    ],
    'boolean' => ':attributeフィールドはtrueまたはfalseでなければなりません。',
    'confirmed' => ':attributeの確認が一致しません。',
    'date' => ':attributeは有効な日付ではありません。',
    'date_equals' => ':attributeは、:dateと等しい日付でなければなりません。',
    'date_format' => ':attributeは:formatの形式と一致しません。',
    'different' => ':attributeと:otherは異なっていなければなりません。',
    'digits' => ':attributeは:digits桁でなければなりません。',
    'digits_between' => ':attributeは、:min〜:maxの数字である必要があります。',
    'dimensions' => ':attributeの画像の寸法が無効です。',
    'distinct' => ':attributeフィールドに重複した値があります。',
    'email' => ':attributeは有効なメールアドレスでなければなりません。',
    'ends_with' => ':attributeは、次のいずれかで終了する必要があります::values',
    'exists' => '選択された:attributeは無効です。',
    'file' => ':attributeはファイルでなければなりません。',
    'filled' => ':attributeフィールドには値が必要です。',
    'gt' => [
        'numeric' => ':attributeは:valueより大きくなければなりません。',
        'file' => ':attributeは:valueキロバイトより大きくなければなりません。',
        'string' => ':attributeは:value文字より大きくなければなりません。',
        'array' => ':attributeには:value以上のアイテムが必要です。',
    ],
    'gte' => [
        'numeric' => ':attributeは:value以上でなければなりません。',
        'file' => ':attributeは:valueキロバイト以上でなければなりません。',
        'string' => ':attributeは:value文字以上でなければなりません。',
        'array' => ':attributeには:value以上のアイテムが必要です。',
    ],
    'image' => ':attributeは画像でなければなりません。',
    'in' => '選択された:attributeは無効です。',
    'in_array' => ':attributeフィールドは:otherに存在しません。',
    'integer' => ':attributeは整数でなければなりません。',
    'ip' => ':attributeは有効なIPアドレスでなければなりません。',
    'ipv4' => ':attributeは有効なIPv4アドレスでなければなりません。',
    'ipv6' => ':attributeは有効なIPv6アドレスでなければなりません。',
    'json' => ':attributeは有効なJSON文字列でなければなりません。',
    'lt' => [
        'numeric' => ':attributeは:value未満でなければなりません。',
        'file' => ':attributeは:valueキロバイト未満でなければなりません。',
        'string' => ':attributeは:value文字未満でなければなりません。',
        'array' => ':attributeには:value未満のアイテムが必要です。',
    ],
    'lte' => [
        'numeric' => ':attributeは:value以下でなければなりません。',
        'file' => ':attributeは:valueキロバイト以下でなければなりません。',
        'string' => ':attributeは:value文字以下でなければなりません。',
        'array' => ':attributeには:value以上のアイテムを含めることはできません。',
    ],
    'max' => [
        'numeric' => ':attributeは:maxより大きくてはいけません。',
        'file' => ':attributeは:maxキロバイトを超えることはできません。',
        'string' => ':attributeは、:max文字を超えることはできません。',
        'array' => ':attributeには:maxアイテムを超えることはできません。',
    ],
    'mimes' => ':attributeは、タイプ:valuesのファイルでなければなりません。',
    'mimetypes' => ':attributeは、タイプ:valuesのファイルでなければなりません。',
    'min' => [
        'numeric' => ':attributeは少なくとも:minでなければなりません。',
        'file' => ':attributeは少なくとも:minキロバイトでなければなりません。',
        'string' => ':attributeは少なくとも:min文字でなければなりません。',
        'array' => ':attributeには少なくとも:min個のアイテムが必要です。',
    ],
    'not_in' => '選択された:attributeは無効です。',
    'not_regex' => ':attribute形式は無効です。',
    'numeric' => ':attributeは数値でなければなりません。',
    'present' => ':attributeフィールドが存在する必要があります。',
    'regex' => ':attribute形式は無効です。',
    'required' => ':attributeフィールドは必須です。',
    'required_if' => ':otherが:valueの場合、:attributeフィールドは必須です。',
    'required_unless' => ':othersが:valuesにない限り、:attributeフィールドは必須です。',
    'required_with' => ':valuesが存在する場合、:attributeフィールドは必須です。',
    'required_with_all' => ':valuesが存在する場合、:attributeフィールドは必須です。',
    'required_without' => ':valuesが存在しない場合、:attributeフィールドは必須です。',
    'required_without_all' => ':valuesが存在しない場合、:attributeフィールドは必須です。',
    'same' => ':attributeと:otherは一致する必要があります。',
    'size' => [
        'numeric' => ':attributeは:sizeでなければなりません。',
        'file' => ':attributeは:sizeキロバイトでなければなりません。',
        'string' => ':attributeは:size文字でなければなりません。',
        'array' => ':attributeには:sizeアイテムが含まれている必要があります。',
    ],
    'starts_with' => ':attributeは、次のいずれかで始まる必要があります::values',
    'string' => ':attributeは文字列でなければなりません。',
    'timezone' => ':attributeは有効なゾーンでなければなりません。',
    'unique' => ':attributeはすでに使用されています。',
    'uploaded' => ':attributeはアップロードに失敗しました。',
    'url' => ':attribute形式は無効です。',
    'uuid' => ':attributeは有効なUUIDでなければなりません。',

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


    'exception' => [
        'message' => '指定されたデータは無効です！ エラーリスト :',
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
        'vehicle_no' => 'vehicle number',
        'shipper_no'=> '荷主No ',
        'shipper'=>'荷主 ',
        'shipper_name1'=>'名 1 ',
        'shipper_name2'=>'名 2 ',
        'shipper.abbreviation'=>'略称 ',
        'postal_code' => '郵便番号',
        'address1' => '住所１',
        'address2' => '住所２',
        'phone_number'=>'電話番号',
        'fax_number'=>'FAX番号',
        'furigana'=>'フリガナ',
        'closing_date'=>'締日',
        'payment_date'=>'支払日',
        'at_most_60_letters'=>'最大60文字',
        'bill_to' => '請求先',
        'deposit_registration'=>'入金登録',
        'delete'=>'削除',
        'deposit_year'=>'入金年',
        'deposit_month'=>'入金月',
        'deposit_day'=>'入金日',
        'transfer'=>'振込',
        'offset'=>'相殺',
        'other'=>'その他',
        'transfer_fee'=>'振込手数料',
        'total_credit_amount'=>'合計入金額',
        'invoice_balance'=>'請求残高',
        'yen'=>'円',
        'dispatch_board' => '配車板',
        'dispatch_day' => '配車日',
        'display' => '表示',
        'next_day' => '翌日',
        'two_days_later' => '翌々日',
        'car_no' => '車輌No',
        'driver_name' => 'ドライバー名',
        'morning' => '朝',
        'noon' => '昼',
        'next_product' => '翌積',
        'add' => '追加',
        'printing'=>'印刷',
        'remarks'=>'備考',
        'pl_available'=>'利用できるPL',
        'add_driver'=>'ドライバーを追加',
        'check'=>'小切手',
        'cancel'=>'キャンセル',
        'driver_list' => 'ドライバー一覧 ',
        '10tw' => '10tW',
        '10t_flat' => '10t平',
        '4tw' => '4tW',
        '4t_flat' => '4t平',
        'controller' => 'ﾄﾚｰﾗ',
        'bulk' => 'ﾊﾞﾙｸ',
        'type'=>'車種',
        'name'=>'ドライバー名',
        'mobile_number'=>'携帯番号',
        'max_load'=>'最大積載量',
        'admin'=>'管理者',
        'password'=>'パスワード',
        'invoice_month' => '年月',
        'invoice_day' => '請求日',
        'weekday' => '積日',
        'loading_port' => '積地',
        'drop_off' => '降地',
        'amount' => '金額',
        'delivery_date' => '積日',
        'weight' => '重量',
        'item_price' => '売上',
        'status' => '状態',
        'matter_no' => '案件No',
        'delivery_time' => '納期',
        'invoice_date' => '請求書の日付',
        'total_sales' => '売上',
        'total_consumption_tax' => '消費税',
        'other_totals' => 'その他 ',
        'sales_total' => '合計売上',
        'aggregate'=>'集計',
        '20th'=>'20日',
        '30th'=>'30日',
        'stack_date'=>'積日',
        'unloading_place' => 'Unloading place',
        'down_date' => '降日',
        'stack_time' => '積時間',
        'down_time' => '降時間',
        'vehicle_model' => '車種',
        'shipper_name' => '荷主',
        'stack_point' => '積地',
        'number_t' => 't数',
        'per_ton' => '1t当たり',
        'per_vehicle' => '1車輌当たり',
        'amount_of_money' => '金額',
        'chartered_vehicle' => '傭車',
        'invoice' => '降請求',
        'down_point' => '降地',
        'empty_pl' => '空PL',
        'rental_vehicle_payment' => '傭車支払',
        'item_list' => '案件一覧',
        'item_registration' => '案件登録',
        'required' => 'required',
        'status_of_selection_is_changed_to_incomplete_when_stack_and_current_dates_are_not_same'=>'スタックと現在の日付が同じでない場合、選択のステータスは未完了に変更されます。',
        'yes'=>'はい',
        'none'=>'なし',
        'completed'=>'完了',
        'incomplete'=>'未完了',
        'vehicle_type'=>'車種',
        'update'=>'更新',
        'wing'=>'ウィング',
        'flat'=>'平',
        'trailer'=>'トレーラー',
        'payment_registration' => '支払登録',
        'payment_year' => '支払年',
        'payment_month' => '支払月',
        'payment_day' => '支払日',
        'total_payment' => '合計支払額',
        'outgoing_balance' => '支払残高',
        'unit_price_list' => '単価一覧',
        'car_type' => '車種',
        'unit_price' => '単価',
        'car_types' => [
            'wing'=>'ウィング',
            'flat'=>'平',
            'trailer'=>'トレーラー',
            'bulk'=>'ﾊﾞﾙｸ',
        ],
        'vehicle_list' => '傭車一覧',
        'company_name' => '傭車会社',
        'kana_name' => 'フリガナ',
        'company_abbr' => '略称',
        'address' => '住所',
        'phone' => '電話番号',
        'fax' => 'FAX番号',
        'remark' => '備考',
        'driver_pass'=>'ドライバーのパスワード ',
    ],

];
