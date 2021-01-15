# How to take profit of Ionic and Angular features for App Development: Form management

# Introduction

Angular nos permite utilizar Reactive Forms para trabajar con los formularios de manera reactiva convirtiéndolos en objetos. El objetivo de este artículo es mostrar las herramientas útiles que nos proporciona el framework para gestionar los formularios.
Para mostrar un ejemplo de la vida real se realizará un formulario de login y uno de registro.

# Declaration

Para declarar un formulario con Reactive Forms, necesitamos hacerlo desde el archivo de typescript de la página. Empezaremos por la página de login.

En la declaración del formulario, indicaremos cuales son los form controls que contiene y en cada uno le asignaremos un valor inicial, y unos validadores para poner reglas al formulario.

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

> Para que el directive de Reactive Forms funcione, hay que importar ReactiveFormsModule en la propiedad imports dentro del module de la página.

# Implementation

Después de declararlo, tenemos que añadir el directive [formGroup] en el archivo HTML y dar referencia a los form controls que se han declarado.

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

Para que sea más fácil trabajar con los form controls a nivel individual para validar los errores y mostrar feedback, crearemos un getter para cada uno.

```js
get email() {
    return this.loginForm.get('email');
}

get password() {
    return this.loginForm.get('password');
}
```

Luego, pondremos condicionales en el archivo HTML para mostrar feedback en caso de que se de un error.

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

Finalmente vamos a gestionar el submit del formulario y cómo enviamos sus datos. Para eso recorreremos al evento de Angular (ngSubmit) que detecta cuando se quiere enviar un formulario, ya sea con la tecla enter, o por pulsar el botón de submit.

```html
<form [formGroup]="loginForm" (ngSubmit)="submit()"></form>
```

También crearemos un método submit para realizar la comprobación de que el formulario pase las validaciones y así pueda enviar sus datos.

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

Y así hemos terminado la página de login!

Para hacer la página de register, tendremos que seguir los mismos pasos que en la página de login.

En este caso nos encontramos con una regla extra, que exige que la contraseña y la confirmación de contraseña deben coincidir. Esta regla pide que se debe realizar una validación entre dos campos, así que no se puede aplicar un validador a nivel de form control, si no que se debe aplicar un validador a nivel de Form Group.

En primer lugar, se crea un método para usarlo como validador.

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

Este método se tiene que añadir como validador global de form group.

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

Y finalmente se añade el feedback al HTML

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

Así es como se gestionan los formularios en Angular gracias a la increible herramienta Reactive Forms!

En el próximo artículo hablaré sobre como crear un form control personalizado para poder utilizarlo junto con Reactive Forms.
