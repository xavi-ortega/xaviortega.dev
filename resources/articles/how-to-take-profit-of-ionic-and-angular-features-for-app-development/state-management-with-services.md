# How to take profit of Ionic and Angular features for App Development: State Management with Services

## Introduction

Services are often used as a communication layer between the front-end and back-end in `client-server architecture`. There is a pattern called `Subject with a Service` that allows to control the state of the application within a service.

This pattern is recommended for small and medium-sized projects where it is not necessary to apply a state control library such as Redux or NgRx.

## Previous steps

In order to apply this pattern, we need to have one or more services created, so we will follow the <a href="/article/how-to-take-profit-of-ionic-and-angular-features-for-app-development/the-service-layer" title="The Service Layer" target="_blank">previous article</a> to understand the creation of the services.

## Applying the pattern to an existing service

To apply the pattern to our service we need to add a variable of type `BehaviorSubject` where our state will be contained.

```js
private quizzes$ = new BehaviorSubject<Quiz[]>([]);
```

Afterwards, a method is added to load the state asynchronously at the most interesting point of the application.

In this method, a request is made to the back-end to return the quizzes and save them in the variable `quizzes$`.

```js
load(): void {
    this.http
        .get<Quiz[]>(`${environment.apiUrl}/${GET_ALL_URL}`)
        .pipe(
        catchError((err) => {
            console.error('quiz -> getAll', err);
            return of([]);
        })
    )
    .subscribe((quizzes) => {
        this.quizzes$.next(quizzes);
    });
}
```

This way, we can now modify the methods we had in the service so that they return the state of Quiz.

```js
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, from, Observable, of } from 'rxjs';
import { catchError, filter, find, mapTo, mergeMap, tap } from 'rxjs/operators';
import { Quiz, QuizResults } from 'src/app/interfaces/quiz';
import { HttpCommonService } from 'src/app/utils/http-common.service';
import { update } from 'src/app/utils/state-crud';
import { environment } from 'src/environments/environment';

const GET_ALL_URL = '';
const GET_BY_ID_URL = '';
const SEND_RESULTS_URL = '';

@Injectable({
  providedIn: 'root',
})
export class QuizService {
  private quizzes$ = new BehaviorSubject<Quiz[]>([]);

  constructor(private http: HttpClient, private httpCommon: HttpCommonService) {}

  load(): void {
    this.http
      .get<Quiz[]>(`${environment.apiUrl}/${GET_ALL_URL}`)
      .pipe(
        catchError((err) => {
          console.error('quiz -> getAll', err);
          return of([]);
        })
      )
      .subscribe((quizzes) => {
        this.quizzes$.next(quizzes);
      });
  }

  getAll(): Observable<Quiz[]> {
    return this.quizzes$.asObservable();
  }

  get(id: string): Observable<Quiz> {
    return this.getAll().pipe(
      mergeMap((quizzes) => from(quizzes)), // convert quizzes array to a sequence of observables to find through it
      find((quiz) => quiz.id === Number(id))
    );
  }

  sendResults(id: number, results: QuizResults): Observable<boolean> {
    return this.http
      .post<Quiz>(
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
        tap((quiz) => {
          const quizzes = update(this.quizzes$, id, quiz); // update state
          this.quizzes$.next(quizzes); // set new state
        }),
        mapTo(true),
        catchError((err) => {
          console.error('quiz -> sendResults', err);
          return of(false);
        })
      );
  }
}
```

Whenever we need to get an updated version of the quizzes, we will have to call the load method that will load them asynchronously. Once they are updated, the state and any page or component that is subscribed to it will be updated.

> Depending on the importance of the state we are loading, we will do it in the `app.component.ts` or directly in the page being used. In the case of the example, the loading of quizzes is crucial for the application so it will be done in the App component.

```js
import { Component } from '@angular/core';

import { Platform } from '@ionic/angular';
import { SplashScreen } from '@ionic-native/splash-screen/ngx';
import { StatusBar } from '@ionic-native/status-bar/ngx';
import { QuizService } from './services/quiz/quiz.service';

@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss'],
})
export class AppComponent {
  constructor(
    private platform: Platform,
    private splashScreen: SplashScreen,
    private statusBar: StatusBar,
    private quizService: QuizService
  ) {
    this.initializeApp();
  }

  initializeApp() {
    this.platform.ready().then(() => {
      this.statusBar.styleDefault();
      this.splashScreen.hide();
      this.loadStates();
    });
  }

  loadStates() {
    this.quizService.load();
  }
}
```

To perform mutations in the state, a helper has been created in the utils folder to save the CRUD operations of the state.

```js
import { BehaviorSubject } from "rxjs";

export function update(
    state$: BehaviorSubject<any[]>,
    id: number,
    value: any
): any[] {
    const state = state$.getValue();

    const index = state.findIndex(item => item.id === id);

    state[index] = { ...state[index], ...value };

    return [...state];
}
```

## Conclusion

That is as far as it goes in this article. It is left as an exercise for the user to add the rest of the helpers to modify the state and complete the services of your application.

It is likely that during the series more services will be added and completed. Soon we will have available the repository of the application and a live demo.

Until next time! :)
