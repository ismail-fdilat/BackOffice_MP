@component('mail::message')
# Introduction
<div class="d-flex justify-content-center">
    <h1 >Congratulation</h1>
<h3> You have successfully created your shop</h3>
</div>
<ul>
<li>You can access your shop with the link :<a href='{{$user->name.'.'.$shop->name.'.enjoy.com'}}'>Link</a> </li>
<li>Admin access with  <a href='{{$user->name.'.'.$shop->name.'.enjoy.com/admin'}}'>AdminLink</a> </li>
</ul>
@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
