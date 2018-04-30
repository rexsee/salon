@extends('layouts.email')

@section('content')
    <tr>
        <td align="center" valign="top" width="100%">
            <center>
                <table cellspacing="0" cellpadding="0" width="100%" class="card">
                    <tr>
                        <td style="background-color:#666666; text-align:center; padding:10px; color:white; ">
                            {{env('APP_NAME')}} :: User Feedback
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellspacing="0" cellpadding="20" width="100%">
                                <tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="150" class="data-heading">
                                                    Name:
                                                </td>
                                                <td class="data-value">
                                                    {{$name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="150" class="data-heading">
                                                    Email:
                                                </td>
                                                <td class="data-value">
                                                    {{$email}}
                                                </td>
                                            </tr>
                                        </table>
                                        <pre style="border: 1px solid #888888;width: 100%">{{$message_c}}</pre>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
@stop