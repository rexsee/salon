@if(!empty(session('noty')))
    <script>
        new Noty({
            type: '{{session()->get('notyType','alert')}}',
            {{"timeout: " . session()->get('notyTimeout','5000') . ","}}
            layout: 'topCenter',
            theme: 'nest',
            text: '{{session('noty')}}',
        }).show();
    </script>
@endif
