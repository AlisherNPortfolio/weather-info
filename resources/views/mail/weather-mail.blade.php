<style>
    tr td {
        text-align: center;
    }
</style>

@component('mail::message')
# Hello!!
## Here is today's current temperature data ({{date('d-m-Y')}})
@component('mail::table')
| City Name   |     Temperature     |
| ----------- |:-------------------:|
|  {{$city}}  | {{$temperature}} °С |
@endcomponent
@endcomponent
