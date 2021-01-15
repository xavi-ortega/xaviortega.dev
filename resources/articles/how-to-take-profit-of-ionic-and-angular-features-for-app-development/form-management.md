# How to take profit of Ionic and Angular features for App Development: Form management

# Introduction

Angular allows us to use Reactive Forms to work with forms in a reactive way by converting them into objects. The aim of this article is to show the useful tools provided by the framework for managing forms.

To show a real-life example, a login form and a registration form will be created.

# Declaration

To declare a form with Reactive Forms, we need to do so from the typescript file on the page. We will start with the login page.

In the declaration of the form, we will indicate which are the form controls contained. In each one we will assign an initial value as well as some validators to set some rules to the form.

```js
import { Component, OnInit } from "@angular/core";
import { FormControl, FormGroup, Validators } from "@angular/forms";

@Component({
    selector: "app-login",
    templateUrl: "./login.page.html",
    styleUrls: ["./login.page.scss"]
})
export class LoginPage implements OnInit {
    loginForm: FormGroup;

    constructor() {}

    ngOnInit() {
        this.loginForm = new FormGroup({
            email: new FormControl("", [Validators.required, Validators.email]),
            password: new FormControl("", Validators.required)
        });
    }
}
```

# Implementation

After declaring it, we have to add the directive [formGroup] in the HTML file and reference the form controls that have been declared.

> For the Reactive Forms directive to work, you must import ReactiveFormsModule into the imports property within the page module.

```html
<form [formGroup]="loginForm">
    <ion-item>
        <ion-label>Email</ion-label>
        <ion-input type="email" formControlName="email"></ion-input>
    </ion-item>

    <ion-item>
        <ion-label>Password</ion-label>
        <ion-input type="password" formControlName="password"></ion-input>
    </ion-item>

    <ion-button type="submit">Sign in</ion-button>
</form>
```

To make it easier to work with the form controls individually in order to validate errors and display feedback, we will create a getter for each one.

```js
get email() {
    return this.loginForm.get('email');
}

get password() {
    return this.loginForm.get('password');
}
```

Afterwards, we will put conditionals in the HTML file to show feedback in case of an error.

```html
<form [formGroup]="loginForm">
    <ion-item>
        <ion-label>Email</ion-label>
        <ion-input type="email" formControlName="email"></ion-input>
    </ion-item>

    <p *ngIf="email.errors.required">This field is required</p>
    <p *ngIf="email.errors.email">This field must be an email address</p>

    <ion-item>
        <ion-label>Password</ion-label>
        <ion-input type="password" formControlName="password"></ion-input>
    </ion-item>

    <p *ngIf="password.errors.required">This field is required</p>

    <ion-button type="submit">Sign in</ion-button>
</form>
```

Finally, we will arrange the submission of the form and how we send its data. To do this we will go to the Angular event (ngSubmit) that detects when someone wants to submit a form, either with the enter key or by pressing the submit button.

```html
<form [formGroup]="loginForm" (ngSubmit)="submit()"></form>
```

We will also create a submit method to check that the form passes the validations in order for the data to be sent.

```js
submit() {
    this.loginForm.markAllAsTouched();

    if (this.loginForm.valid) {
        const credentials = this.loginForm.getRawValue();

        this.authService.login(credentials).subscribe((success) => {
            if (success) {
                this.navCntrl.navigateRoot('home');
            } else {
                // error feedback
            }
        });
    }
}
```

That way the login pages is finished!

To make the register page, we will have to follow the same steps as in the login page.

In this case we have an extra rule, which requires the password and the password confirmation to match. This rule demands a validation between the two fields. Hence, a validator cannot be applied at form control level, but at form group level.

Firstly, a method is created to use as a validator.

```js
passwordsMustMatchValidator(): ValidatorFn {
    return (form: FormGroup): ValidationErrors | null => {
        const password = form.get('password');
        const passwordConfirmation = form.get('password_confirmation');

        if (password && passwordConfirmation && password.value !== passwordConfirmation.value) {
            return { passwordMissmatch: true };
        } else {
            return null;
        }
    };
}
```

This method has to be added as a global form group validator.

```js
ngOnInit() {
    this.registerForm = new FormGroup(
      {
        name: new FormControl('', Validators.required),
        email: new FormControl('', [Validators.required, Validators.email]),
        password: new FormControl('', Validators.required),
        password_confirmation: new FormControl('', Validators.required),
      },
      {
        validators: this.passwordsMustMatchValidator(),
      }
    );
  }
```

Lastly, feedback is added to the HTML

```html
<form [formGroup]="registerForm" (ngSubmit)="submit()">
    <ion-item>
        <ion-label>Name</ion-label>
        <ion-input type="text" formControlName="name"></ion-input>
    </ion-item>

    <div *ngIf="name.invalid && (name.dirty || name.touched)">
        <p *ngIf="name.errors.required">This field is required</p>
    </div>

    <ion-item>
        <ion-label>Email</ion-label>
        <ion-input type="email" formControlName="email"></ion-input>
    </ion-item>

    <div *ngIf="email.invalid && (email.dirty || email.touched)">
        <p *ngIf="email.errors.required">This field is required</p>
        <p *ngIf="email.errors.email">This field must be an email address</p>
    </div>

    <ion-item>
        <ion-label>Password</ion-label>
        <ion-input type="password" formControlName="password"></ion-input>
    </ion-item>

    <div *ngIf="password.invalid && (password.dirty || password.touched)">
        <p *ngIf="password.errors.required">This field is required</p>
    </div>

    <ion-item>
        <ion-label>Password confirmation</ion-label>
        <ion-input
            type="password"
            formControlName="password_confirmation"
        ></ion-input>
    </ion-item>

    <div
        *ngIf="passwordConfirmation.invalid && (passwordConfirmation.dirty || passwordConfirmation.touched)"
    >
        <p *ngIf="passwordConfirmation.errors.required">
            This field is required
        </p>
    </div>

    <p
        *ngIf="registerForm.errors?.passwordMissmatch && (registerForm.touched || registerForm.dirty)"
    >
        Passwords should match
    </p>

    <ion-button type="submit">Register</ion-button>
</form>
```

This is how forms are managed in Angular thanks to the incredible Reactive Forms tool!

In the next article I will discuss how to create a customized form control to be used in conjunction with Reactive Forms.
