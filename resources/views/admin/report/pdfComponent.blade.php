<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <meta charset="utf-8"/>
</head>
<style>
    th {
        background-color: rgba(184, 14, 28, 0.72);
        color: white;
    }
    body {
        font-family: XB Riyaz, sans-serif;
    }
    th, td {
        border-bottom: 1px solid #ddd;
        padding: 15px;
    }
    tr:nth-child(even) {background-color: #f2f2f2;}
</style>
<body style="direction: {{app()->getLocale() == 'en'? 'ltr' : 'rtl'}}">
<!--begin::Advance Table Widget 3-->
<div>
    <!--begin::Header-->
    <div>
        <h3>
            <span>{{ __($item.'.'.plural($item)) }}</span>
        </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div>
        <!--begin::Table-->
        <div>
            <table style="width:100%">
                <thead>
                <tr>
                    @foreach($headers as $header)
                        <th style="min-width: 100px">{{ __($item.'.'.$header) }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $row)
                    <tr>
                        @foreach($headers as $header)
                            <td>
                                <span>{{ $row->$header ?? __('admin.empty') }}</span>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!--end::Table-->
    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 3-->

</body>

</html>
