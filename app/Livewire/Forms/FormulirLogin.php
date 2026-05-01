<?php
1: 
2: namespace App\Livewire\Forms;
3: 
4: use Illuminate\Auth\Events\Lockout;
5: use Illuminate\Support\Facades\Auth;
6: use Illuminate\Support\Facades\RateLimiter;
7: use Illuminate\Support\Str;
8: use Illuminate\Validation\ValidationException;
9: use Livewire\Attributes\Validate;
10: use Livewire\Form;
11: 
12: class FormulirLogin extends Form
13: {
14:     #[Validate('required|string|email')]
15:     public string $email = '';
16: 
17:     #[Validate('required|string')]
18:     public string $password = '';
19: 
20:     #[Validate('boolean')]
21:     public bool $remember = false;
22: 
23:     /**
24:      * Attempt to authenticate the request's credentials.
25:      *
26:      * @throws ValidationException
27:      */
28:     public function authenticate(): void
29:     {
30:         $this->ensureIsNotRateLimited();
31: 
32:         if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
33:             RateLimiter::hit($this->throttleKey());
34: 
35:             throw ValidationException::withMessages([
36:                 'form.email' => trans('auth.failed'),
37:             ]);
38:         }
39: 
40:         RateLimiter::clear($this->throttleKey());
41:     }
42: 
43:     /**
44:      * Ensure the authentication request is not rate limited.
45:      */
46:     protected function ensureIsNotRateLimited(): void
47:     {
48:         if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
49:             return;
50:         }
51: 
52:         event(new Lockout(request()));
53: 
54:         $seconds = RateLimiter::availableIn($this->throttleKey());
55: 
56:         throw ValidationException::withMessages([
57:             'form.email' => trans('auth.throttle', [
58:                 'seconds' => $seconds,
59:                 'minutes' => ceil($seconds / 60),
60:             ]),
61:         ]);
62:     }
63: 
64:     /**
65:      * Get the authentication rate limiting throttle key.
66:      */
67:     protected function throttleKey(): string
68:     {
69:         return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
70:     }
71: }
