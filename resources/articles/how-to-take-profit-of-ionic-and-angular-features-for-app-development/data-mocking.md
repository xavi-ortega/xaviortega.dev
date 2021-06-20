# How to Take Profit of Ionic and Angular Features for App Development: Data Mocking

## Introduction

We often find ourselves in a project where the front-end and back-end are split between two different teams and are developed at a different pace.

If you are in charge of the front-end, you are likely to find yourself in the situation where you have developed several pages and services of the application, but the API endpoints are not yet ready.

To solve this productivity problem, we use data mocking. It allows us to use JSON files to populate our application with data, without the need for a back-end and without significantly changing the structure of our project.

## Previous steps

To place the JSON files that we will use as a database, we will add a new folder inside the assets folder where we will create the mock data.

```tree
├── app
├── assets
|   └─── db
├── environments
├── theme
├── global.scss
├── index.html
├── main.ts
├── polyfills.ts
├── test.ts
└── zone-flags.ts
```

For this project, we only need a few quizzes with their respective questions so far. Hence, we will create the file quizzes.json.

```tree
├── assets
    └─── db
         └─── quizzes.json
```

## Implementation

Once the file with the quizzes data is created, we will modify the service to get the data from it.

> In the previous articles, we have always extracted the API endpoints in a constant. This way, it is very easy to modify them without altering the structure of the file following SOLID principles.

```js
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, from, Observable, of } from 'rxjs';
import { catchError, filter, find, mapTo, mergeMap, tap } from 'rxjs/operators';
import { Quiz, QuizResults } from 'src/app/interfaces/quiz';
import { HttpCommonService } from 'src/app/utils/http-common.service';
import { update } from 'src/app/utils/state-crud';
import { environment } from 'src/environments/environment';

const GET_ALL_URL = 'assets/db/quizzes.json';
(...)

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

  (...)
}
```

Also, we can fill our application with data without the need of a back-end to build the HTML and styles.

## Switch between mock and real data

To switch between mock and real data, there are different techniques that can be used. Among them, I will distinguish two in this article.

For both solutions, we will need to use the environment files provided by any Angular project.

If you only have one environment in the back-end, you just need to make the following modification in the quizzes service.

> By back-end environment, I mean that there is no pre-production environment where the API is uploaded nor a development environment.

```js
const GET_ALL_URL = environment.production
    ? "/api/quizzes"
    : "assets/db/quizzes.json";
```

In this case, it is enough to distinguish production from development. So, depending on the build that is done in the application, it will use mock or real data.

When there is more than one environment, you must add another variable in the environments to decide whether to use mock data and you must change it manually when you want to use it or not.

At environment.ts

```js
export const environment = {
    production: false,
    apiUrl: "", // mock data url
    // apiUrl: 'http://localhost:8000/api', // preproduction url
    mockData: true,
};
```

At environment.prod.ts

```js
export const environment = {
    production: true,
    apiUrl: "https://xaviortega.dev/api",
    mockData: false,
};
```

Finally, we apply the use of the new environment variable in the service.

```js
const GET_ALL_URL = environment.mockData
    ? "/api/quizzes"
    : "assets/db/quizzes.json";
```

## Conclusion

This is it for today's article about data mocking. This will allow me to upload a demo of the application on the web without the need of a back-end!

There are more sophisticated methods to avoid having to change the environment file manually, such as creating a custom environment. However, I have not covered that because I do not see the need to add more complexity to the project for something temporary like the mock data.

See you in the next article!
