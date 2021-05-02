<?php

function check_stylist_availability($stylist_id, \Carbon\Carbon $date, $minutes_needed, $check_available = false)
{
    $booking_fo_the_day = \App\Models\Booking::where('booking_date', 'like', $date->toDateString() . '%')
        ->where('stylist_id', $stylist_id)
        ->whereIn('status', ['Confirmed', 'Postpone'])
        ->get();

    $taken_time = [];
    $remark = '';

    foreach ($booking_fo_the_day as $data) {
        for ($i = $data->booking_date; $i < $data->booking_date->addMinutes($data->minutes_take); $i->addMinutes(30)) {
            $taken_time[] = $i->format('Hi');
        }
    }

    if (
        in_array($date->format('Hi'), $taken_time)
        || in_array($date->addMinutes($minutes_needed)->format('Hi'), $taken_time)
    ) {
        $available_time = [];
        if ($check_available) {
            $key = '';
            for ($i = \Carbon\Carbon::parse($date->toDateString() . ' 1030'); $i < \Carbon\Carbon::parse($date->toDateString() . ' 2000'); $i->addMinutes(30)) {
                if (empty($key)) {
                    $key = $i->format('Hi');
                }
                if (!in_array($i->format('Hi'), $taken_time)) {
                    $available_time[$key] = empty($available_time[$key]) ? 1 : $available_time[$key] + 1;
                } else {
                    $key = \Carbon\Carbon::parse($i->toDateTimeString())->addMinutes(30)->format('Hi');
                }
            }

            $available_time_of_day = '';
            foreach ($available_time as $time => $section) {
                if ($section >= $minutes_needed / 30) {
                    $available_time_of_day .= $time . ', ';
                }
            }

            if (!empty($available_time_of_day)) {
                $remark = 'If you still want to book this stylist on the same day, you can book at ' . substr($available_time_of_day,
                        0, -2) . '. Else you can book on other day.';
            } else {
                $remark = 'Please try again with other day.';
            }
        }

        $status = false;
    } else {
        $status = true;
    }

    return ['status' => $status, 'remark' => $remark];
}

function getFormattedDateRange($dateStr)
{
    $dates = explode('-', $dateStr);
    if (count($dates) != 2) {
        return [];
    }
    $return[] = trim(str_replace('/', '-', $dates[0])) . ' 00:00:00';
    $return[] = trim(str_replace('/', '-', $dates[1])) . ' 23:59:59';

    return $return;
}

function get_specialty()
{
    return [
        'color-artist' => 'Color Artist',
        'make-overs' => 'Make-Overs',
        'evening-styles' => 'Evening Styles',
        'mens-styles' => 'Men\'s Styles',
        'extensions' => 'Extensions',
    ];
}

function format_specialty($string)
{
    $arr = explode(',', $string);
    $specialtyList = get_specialty();

    $return_string = '';
    foreach ($arr as $item) {
        $return_string .= empty($specialtyList[$item]) ? '' : ($specialtyList[$item] . ', ');
    }

    return substr($return_string, 0, -2);
}

function format_phone($phone){
    $phone = str_replace('-','',$phone);
    $phone = str_replace('(','',$phone);
    $phone = str_replace(')','',$phone);
    $phone = str_replace(' ','',$phone);
    $phone = str_replace('.','',$phone);
    $phone = str_replace('_','',$phone);
    return $phone;
}

function component_sort_link($link, $display_name, $name, $sort_by = '', $sort = 'asc'){
    $need_to_sort_by = $sort;
    if ($name == $sort_by) {
        if ($sort == 'asc') {
            $img_path = asset('images/sort_asc.png');
            $need_to_sort_by = 'desc';
        } else {
            $img_path = asset('images/sort_desc.png');
            $need_to_sort_by = 'asc';
        }
    } else {
        $img_path = asset('images/sort_both.png');
    }

    if (str_contains($link,'?')){
        $str = "<a href='$link&sort_by=$name&sort=$need_to_sort_by'>$display_name <img src='$img_path' /> </a>";
    } else {
        $str = "<a href='$link?sort_by=$name&sort=$need_to_sort_by'>$display_name <img src='$img_path' /></a>";
    }

    return $str;

}

function getProductCollections($key = ''){
    $data = [
        'morphosis'=>'MORPHOSIS',
        'viege'=>'Viege',
        'framesi'=>'FRAMESI',
        'others'=>'Others'
    ];

    if (!empty($key)) {
        return @$data[$key];
    } else {
        return $data;
    }
}

function getCustomerCategory($key = null)
{
    $data = [
        'VVIP'=>'VVIP',
        'VIP'=>'VIP',
        'POTENTIAL'=>'POTENTIAL',
        'STANDARD'=>'STANDARD',
        'C/O'=>'C/O',
        'BKT'=>'BKT',
        'BLOCKED'=>'BLOCKED',
    ];

    if (!empty($key)) {
        return @$data[$key];
    } else {
        return $data;
    }
}

function sort_link($displayName, $key) {
    $queryString = request()->query();
    $currentLink = url()->current();
    unset($queryString['page']);

    $icon = '<i class="fa fa-lg fa-sort"></i> ';
    $currentSort = @$queryString['order_by'];
    $sort = empty($queryString['order_type']) ? 'DESC' : $queryString['order_type'];
    $style = '';
    if (!empty($currentSort)) {
        $expCurrent = explode(' ',$currentSort);
        if ($currentSort == $key) {
            $style = 'color:#00168e !important; text-decoration:underline';

            if ($sort == 'DESC') {
                $icon = '<i class="soft-link-icon fa fa-lg fa-sort-down"></i> ';
                $sort = 'ASC';
            } else {
                $icon = '<i style="top:5px;" class="soft-link-icon fa fa-lg fa-sort-up"></i> ';
                $sort = 'DESC';
            }
        }
    }

    $queryString['order_by'] = $key;
    $queryString['order_type'] = $sort;
    return new \Illuminate\Support\HtmlString('<a style="'.$style.'" href="'.url()->current() . '?' . http_build_query($queryString) .'">'.$icon . $displayName.'</a>');
}
