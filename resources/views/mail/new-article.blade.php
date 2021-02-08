@component('mail::message')
# What's up?

I have just recently published a new article! Feel free to check it out

@component('mail.partials.article', ['article' => $article])
Button Text
@endcomponent

See you next time,<br>
{{ config('app.name') }}
@endcomponent
