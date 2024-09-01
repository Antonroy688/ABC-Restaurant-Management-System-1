@php($footer_link = \App\Models\GeneralSetting::where('key', 'footer_link')->first())
@php($footer_text = \App\Models\GeneralSetting::where('key', 'footer_text')->first())
<footer class="footer text-center">
               {{$footer_text->value??''}} <a href="{{$footer_link->value??'#'}}">Maestro Innovative Solutions(pvt) Ltd</a>.
</footer>