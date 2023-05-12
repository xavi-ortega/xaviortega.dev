# How to Take Profit of Ionic and Angular Features for App Development: Authentication

## Introduction

User authentication is a feature required in most projects today. However, it is not always evident which are the steps to follow, or how to structure the code so that each tool involved has its part to play.
In this article, we will address the different parts that a Ionic 5 project needs in order to add user authentication.

## auth.service.ts

Firstly, we will create an angular service as a layer between the requests that will be processed in the server and our application.

```bash
$ ionic g service services/auth
```

The responsibility of this service, apart from making the HTTP requests, will be to interact with the local storage of our device to save the user authentication token.

> If you are not using Capacitor, you will have to install the Storage cordova plugin.

The service will implement the Subject with a Service pattern, which will be covered in another article about app status management.

Our user authentication service will need 4 methods and 2 attributes.

```js
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable, of } from 'rxjs';
import { Plugins } from '@capacitor/core';
import { HttpClient } from '@angular/common/http';
import { AuthResponse } from '../interfaces/auth';
import { mapTo, catchError, tap } from 'rxjs/operators';
import { environment } from 'src/environments/environment';

const { Storage } = Plugins;

const AUTH_STORAGE_KEY = 'app/auth';

const LOGIN_URL = 'login';
const REGISTER_URL = 'register';
const LOGOUT_URL = 'logout';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private token$: BehaviorSubject<string> = new BehaviorSubject('');
  private isAuthenticated$: BehaviorSubject<boolean> = new BehaviorSubject(false);

  constructor(private http: HttpClient) {
    //
  }

  check(): boolean {
    //
  }

  login(credentials): Observable<boolean> {
    //
  }

  register(data): Observable<boolean> {
    //
  }

  logout(): Observable<boolean> {
    //
  }
}

```

The attributes will be BehaviorSubject type Observables to be able to obtain and modify their value at any time in a synchronous way.

The check method will be used to know if there is an active user session at that moment.

```js
check(): boolean {
  return this.isAuthenticated$.getValue();
}
```

The login method will be used to log in. It will consist of a POST request to the server with the user's credentials, and it will obtain a token to keep the session active as an answer. Once the token has been saved, the process is considered to be complete and finally our method returns true. In case any error has occurred or the user's credentials are incorrect, it will return false.

```js
login(credentials): Observable<boolean> {
  return this.http.post<AuthResponse>(`${environment.apiUrl}/${LOGIN_URL}`, credentials).pipe(
    tap(({ token, user }) => {
      if (token) {
        this.setAuth(token);
      }
    }),
    mapTo(true),
    catchError((err) => {
      console.error('login', err);
      return of(false);
    })
  );
}

private setAuth(token: string) {
  this.token$.next(token);

  Storage.set({
    key: AUTH_STORAGE_KEY,
    value: token,
  });

  this.isAuthenticated$.next(true);
}
```

The register method will be used to register a new user. It will consist of a POST request to the server with all the user's information, and you will get a success message or an error message in response. As in the login method, if the process is successful, it will return true. If not, it will return false.

```js
register(data): Observable<boolean> {
  return this.http.post(`${environment.apiUrl}/${REGISTER_URL}`, data).pipe(
    mapTo(true),
    catchError((err) => {
      console.error('register', err);
      return of(false);
    })
  );
}
```

The logout method is similar. Following the same structure as login and register, it will return true or false, and it will remove all information about the user's session.

```js
logout(): Observable<boolean> {
  return this.http.post(`${environment.apiUrl}/${LOGOUT_URL}`, {}).pipe(
    tap(() => {
      this.clearAuth();
    }),
    mapTo(true),
    catchError((err) => {
      console.error('logout', err);
      return of(false);
    })
  );
}

private clearAuth() {
  this.token$.next('');

  Storage.remove({
    key: AUTH_STORAGE_KEY,
  });

  this.isAuthenticated$.next(false);
}
```

The service constructor method checks if there is any user session saved in the Storage and if the user is authenticated without the need to login.

```js
constructor(private http: HttpClient) {
  Storage.get({
    key: AUTH_STORAGE_KEY,
  }).then(({ value: token }) => {
    if (token) {
      this.setAuth(token);
    }
  });
}
```

## auth.guard.ts

Once the authentication service has been completed, we proceed to create an authentication Guard to control access to the application pages.

```bash
$ ionic g guard guards/auth --implements CanActivate
```

The Guard will use the check method of the authentication service to find out if it can allow the user to access the page or not. If this is not the case, it is the responsibility of the Guard to redirect the user to the login page in order to authenticate himself.

> Guards can also implement the CanDeactivate and CanLoad interface, which can allow more interesting features, which will be covered in another article.

```js
import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree } from '@angular/router';
import { NavController } from '@ionic/angular';
import { Observable } from 'rxjs';
import { AuthService } from '../services/auth.service';

@Injectable({
  providedIn: 'root',
})
export class AuthGuard implements CanActivate {
  constructor(private authService: AuthService, private navCntrl: NavController) {}

  canActivate(next: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> | boolean {
    if (this.authService.check()) {
      return true;
    }

    this.navCntrl.navigateRoot('login');

    return false;
  }
}
```

## unauthorized.interceptor.ts

As a last security measure to manage the authentication in our application, an HttpInterceptor will be used.

The responsibility of the Interceptor is to monitor all requests made to the server. In the event that the server gives an authentication error response, it must redirect the user to the login page so that they can authenticate themselves.

```js
import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { NavController } from '@ionic/angular';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root',
})
export class UnauthorizedInterceptor implements HttpInterceptor {
  constructor(private navCntrl: NavController) {}

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(req).pipe(
      catchError((error: HttpErrorResponse) => {
        if (error.status === 401) {
          console.error('interceptor: no session');

          this.navCntrl.navigateRoot('login');
        }

        return throwError(error);
      })
    );
  }
}
```

We must remember that the interceptors are executed in each request that is made to the server, as long as they are registered. To register an interceptor, it must be provided in the array of providers: [] in our root module, usually AppModule.

```js
import { NgModule } from "@angular/core";
import { BrowserModule } from "@angular/platform-browser";
import { RouteReuseStrategy } from "@angular/router";

import { IonicModule, IonicRouteStrategy } from "@ionic/angular";
import { SplashScreen } from "@ionic-native/splash-screen/ngx";
import { StatusBar } from "@ionic-native/status-bar/ngx";

import { AppComponent } from "./app.component";
import { AppRoutingModule } from "./app-routing.module";
import { HTTP_INTERCEPTORS } from "@angular/common/http";
import { UnauthorizedInterceptor } from "./interceptors/unauthorized.interceptor";

@NgModule({
    declarations: [AppComponent],
    entryComponents: [],
    imports: [BrowserModule, IonicModule.forRoot(), AppRoutingModule],
    providers: [
        StatusBar,
        SplashScreen,
        { provide: RouteReuseStrategy, useClass: IonicRouteStrategy },
        {
            provide: HTTP_INTERCEPTORS,
            useClass: UnauthorizedInterceptor,
            multi: true,
        },
    ],
    bootstrap: [AppComponent],
})
export class AppModule {}
```

## Summary

These are the three players involved in user authentication for an Ionic application. Based on this structure, more elaborate and error-controlled authentication processes can be carried out if the project requires it.

Do you think I've overlooked anything? Please let me know :)
