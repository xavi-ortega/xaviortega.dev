# How to take profit of Ionic and Angular features for App Development: The Service Layer

## Introduction

The service layer serves as an intermediary between the back-end and the front-end. It communicates through HTTP requests to send and receive data.

Apart from that functionality, these services can also be used as a simple way to control the state of the application at feature level. This pattern is called Subject with a Service which we will see in the next article.

To demonstrate how the service layer is implemented, today we will create a service for our application that will be used to get the questions of a quiz and to answer them.

## Previous steps

Before we start creating our services, we need to make a small modification to the auth.service.ts that we created in the <a href="/article/how-to-take-profit-of-ionic-and-angular-features-for-app-development/authentication" title="Authentication" target="_blank">Authentication article</a>.

We will create a service that will be used as a helper to store headers and other usual bits and pieces that have to do with the HTTP protocol.

```bash
ionic g service utils/http-common --skipTests
```

```js
import { HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class HttpCommonService {
  private headers: HttpHeaders;

  constructor() {}

  setHeaders(headers: HttpHeaders) {
    this.headers = headers;
  }

  getHeaders(): HttpHeaders {
    return this.headers;
  }
}

```

After that, we will proceed to modify the AuthService so that the headers are saved once the user is authenticated.

```js
  private setAuth(token: string) {
    this.token$.next(token);

    Storage.set({
      key: AUTH_STORAGE_KEY,
      value: token,
    });

    this.httpCommon.setHeaders(
      new HttpHeaders({
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`,
      })
    );

    this.isAuthenticated$.next(true);
  }

  private clearAuth() {
    this.token$.next('');

    Storage.remove({
      key: AUTH_STORAGE_KEY,
    });

    this.httpCommon.setHeaders(undefined);

    this.isAuthenticated$.next(false);
  }
```

## quiz.service.ts

First, we will create an Angular service dedicated to quizzes as a layer between the requests that will be made on the server, and our application.

```bash
ionic g service services/quiz/quiz
```

Before we start adding methods to the service, we will create the necessary interfaces to manage the quizzes in `interfaces/quiz.ts`.

```js
export interface Quiz {
    id: number;
    title: string;
    mark?: number;
    body?: string;
    questions?: QuizQuestion[];
}

export interface QuizResults {
    answers: QuizAnswer[];
}

interface QuizQuestion {
    id: number;
    label: string;
    items: QuizQuestionItem[];
}

interface QuizQuestionItem {
    id: number;
    label: string;
    value: number;
}

interface QuizAnswer {
    id: number;
    value: number | number[];
}
```

Once created, we will add the methods needed to cover the quiz needs.

```js
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { catchError, mapTo } from 'rxjs/operators';
import { Quiz, QuizResults } from 'src/app/interfaces/quiz';
import { HttpCommonService } from 'src/app/utils/http-common.service';
import { environment } from 'src/environments/environment';

const GET_ALL_URL = '';
const GET_BY_ID_URL = '';
const SEND_RESULTS_URL = '';

@Injectable({
  providedIn: 'root',
})
export class QuizService {
  constructor(private http: HttpClient, private httpCommon: HttpCommonService) {}

  getAll(): Observable<Quiz[]> {
    return this.http.get<Quiz[]>(`${environment.apiUrl}/${GET_ALL_URL}`).pipe(
      catchError((err) => {
        console.error('quiz -> getAll', err);
        return of([]);
      })
    );
  }

  get(id: string): Observable<Quiz> {
    return this.http
      .get<Quiz>(`${environment.apiUrl}/${GET_BY_ID_URL}`, {
        headers: this.httpCommon.getHeaders(),
        params: {
          id,
        },
      })
      .pipe(
        catchError((err) => {
          console.error('quiz -> get', err);
          return of(undefined);
        })
      );
  }

  sendResults(id: number, results: QuizResults): Observable<boolean> {
    return this.http
      .post<boolean>(
        `${environment.apiUrl}/${SEND_RESULTS_URL}`,
        {
          id,
          results,
        },
        {
          headers: this.httpCommon.getHeaders(),
        }
      )
      .pipe(
        mapTo(true),
        catchError((err) => {
          console.error('quiz -> sendResults', err);
          return of(false);
        })
      );
  }
}
```

## Usage

The services will be used directly in the controller of the pages of our application. A good practice for using Observables is to create a variable ending with the character `$` and assign it in the `ngOnInit` method.

Let's test our service on the Home page.

To start with, we will use the getAll method to get a list of quizzes and display it on the screen.

```js
import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Observable } from 'rxjs';
import { Quiz } from 'src/app/interfaces/quiz';
import { QuizService } from 'src/app/services/quiz/quiz.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.page.html',
  styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {
  quizzes$: Observable<Quiz[]>;

  constructor(private quizService: QuizService) {}

  ngOnInit() {
    this.quizzes$ = this.quizService.getAll();
  }
}
```

To subscribe to an Observable in the HTML we will use Angular's AsyncPipe, which unsubscribes automatically and we do not need to manage it.

```html
<ion-header>
    <ion-toolbar>
        <ion-title>Quiz List</ion-title>
    </ion-toolbar>
</ion-header>

<ion-content>
    <ion-list *ngIf="quizzes$ | async as quizzes">
        <ion-item
            *ngFor="let quiz of quizzes"
            [routerLink]="['/quiz', quiz.id]"
        >
            <ion-label>{{ quiz.title }}</ion-label>
            <ion-badge *ngIf="quiz.mark; else toDo" slot="end" color="primary">
                {{ quiz.mark }}
            </ion-badge>

            <ng-template #toDo>
                <ion-badge slot="end" color="warning"> TO DO </ion-badge>
            </ng-template>
        </ion-item>
    </ion-list>
</ion-content>
```

To use the rest of the methods in our service, we have created a Quiz page to take the quizzes and send the results.

> To pass a parameter as a variable path, you have to modify our path in `app/app-routing.module.ts`

```js
import { NgModule } from "@angular/core";
import { PreloadAllModules, RouterModule, Routes } from "@angular/router";

const routes: Routes = [
    {
        path: "",
        pathMatch: "full",
        redirectTo: "home"
    },
    {
        path: "login",
        loadChildren: () =>
            import("./pages/login/login.module").then(m => m.LoginPageModule)
    },
    {
        path: "register",
        loadChildren: () =>
            import("./pages/register/register.module").then(
                m => m.RegisterPageModule
            )
    },
    {
        path: "home",
        loadChildren: () =>
            import("./pages/home/home.module").then(m => m.HomePageModule)
    },
    {
        path: "quiz/:id",
        loadChildren: () =>
            import("./pages/quiz/quiz.module").then(m => m.QuizPageModule)
    }
];

@NgModule({
    imports: [
        RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
    ],
    exports: [RouterModule]
})
export class AppRoutingModule {}
```

In the Quiz page, we get the URL parameter using `ActivatedRoute`.

```js
import { Component, OnInit } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { Observable } from 'rxjs';
import { Quiz } from 'src/app/interfaces/quiz';
import { QuizService } from 'src/app/services/quiz/quiz.service';

@Component({
  selector: 'app-quiz',
  templateUrl: './quiz.page.html',
  styleUrls: ['./quiz.page.scss'],
})
export class QuizPage implements OnInit {
  id: string;

  quiz$: Observable<Quiz>;

  constructor(private quizService: QuizService, private activatedRoute: ActivatedRoute) {}

  ngOnInit() {
    this.id = this.activatedRoute.snapshot.params.id;

    this.quiz$ = this.quizService.get(this.id);
  }

  submit() {
    const results: any = {};

    this.quizService.sendResults(+this.id, results).subscribe((success) => {
      if (success) {
        // success feedback
      } else {
        // error sending results
      }
    });
  }
}
```

Finally, we render the HTML with the results obtained from the service.

```html
<ng-container *ngIf="quiz$ | async as quiz">
    <ion-header>
        <ion-toolbar>
            <ion-title>{{ quiz.title }}</ion-title>
        </ion-toolbar>
    </ion-header>

    <ion-content>
        <ion-text> {{ quiz.body }} </ion-text>

        <ng-container *ngFor="let question of quiz.questions">
            <ion-label>{{ question.label }}</ion-label>
            <reorder-control [items]="question.items"></reorder-control>
        </ng-container>

        <ion-button (click)="submit()">Send</ion-button>
    </ion-content>
</ng-container>
```

## For the Promise-lovers

If you are a Promise-lover and you are not yet familiar with the use of Observables, you can always use this little trick :)

```js
export class HomePage implements OnInit {
  quizes: Quiz[];

  constructor(private quizService: QuizService) {}

  async ngOnInit() {
    this.quizes = await this.quizService.getAll().toPromise();
  }
}
```

## Conclusion

This is as far as we have got in today's article. Services are an essential part of all applications that require a back-end. Therefore, it is very important to have them well-organised and with clean code.

In the next article we will deal with the Subject with a Service pattern to be able to control the state of our application without the need of extra libraries (Redux, NgRx, etc).
