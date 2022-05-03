# How to take profit of Ionic and Angular features for App Development: Project Structure

## Introduction

When you work in a team with developers who are responsible for the same codebase, it is crucial that everyone has an understanding of how the application should be structured.

The aim of this article is to propose a scalable and manageable structure for any small to large-scale project.

> It is almost impossible to find a structure that works for all projects. Nevertheless, the aim of this project is to show an architecture that should serve any standard Ionic project.

## Fresh installation

To achieve a structure that is simple to remember for all developers, it is important to take advantage of the fresh installation provided by Ionic, which already has got a well-organised architecture.

```tree
├── e2e
├── node_modules
├── src
├── .gitignore
├── angular.json
├── ionic.config.json
├── karma.conf.js
├── package-lock.json
├── package.json
├── tsconfig.app.json
├── tsconfig.json
├── tsconfig.spec.json
└── tslint.json
```

This article will focus on the interior of the `src` folder, to prepare a proper structure for the project.

## The src folder

```tree
├── app
├── assets
├── environments
├── theme
├── global.scss
├── index.html
├── main.ts
├── polyfills.ts
├── test.ts
└── zone-flags.ts
```

### The app folder

To provide a good structure for the `app` folder, we must remove the home page that gives us the fresh installation of Ionic as a boilerplate. Afterwards, we will add the `components`, `guards`, `interceptors`, `interfaces`, `pages` and `services` folders.

Eventually the folder should look like this:

```tree
├── components
├── guards
├── interceptors
├── interfaces
├── pages
├── services
├── app-routing.module.ts
├── app.component.html
├── app.component.scss
├── app.component.spec.ts
├── app.component.ts
└── app.module.ts
```

### The assets folder

We will add an `img` folder to store our project images, and in case the application needs to display videos and audio, the pertinent folders should also be created.

Eventually the folder should look like this:

```tree
├── icon
├── img
└── shapes.svg
```

## Summary

Selecting a structure for a project is not straightforward as one must agree with the other team members. However, once a successful structure is achieved, it can last for years.

In the next series of episodes, I will explain the utility of the parts of this architecture that would be functional for 90% of the use-cases.
