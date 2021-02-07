# How to take profit of Ionic and Angular features for App Development: Custom Form Control

## Introduction

Angular allows us to create custom form controls so that we can put them together with the other controls on a form and have all the data centralised in a single form to send to the server.

To demonstrate how to create a custom form control, we will create a component to order sentences.

## Creation

To generate a custom form control, the first step is to create an Angular component with the word "control" in its name so as to maintain a clean structure in the project.

```bash
ionic g component components/reorder-control
```

In the components module, we will have to add the declaration of the component and export it so that it can be used in all the pages that import the `components.module.ts`.

```js
import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { ReorderControlComponent } from "./reorder-control/reorder-control.component";

@NgModule({
    declarations: [ReorderControlComponent],
    imports: [CommonModule],
    exports: [ReorderControlComponent]
})
export class ComponentsModule {}
```

After adding it to the module, we are going to implement the component without converting it to a form control at this stage.

```html
<ion-reorder-group (ionItemReorder)="doReorder($event)" [disabled]="disabled">
    <ion-reorder *ngFor="let item of items">
        <ion-item>
            <ion-label>{{ item.label }}</ion-label>
        </ion-item>
    </ion-reorder>
</ion-reorder-group>
```

```js
import { Component, Input, OnInit } from "@angular/core";
import { ItemReorderEventDetail } from "@ionic/core";

interface ReorderItem {
    label: string;
    value: number;
}

@Component({
    selector: "reorder-control",
    templateUrl: "./reorder-control.component.html",
    styleUrls: ["./reorder-control.component.scss"]
})
export class ReorderControlComponent implements OnInit {
    @Input() items: ReorderItem[];

    disabled: boolean = false;

    constructor() {}

    ngOnInit() {}

    doReorder(ev: CustomEvent<ItemReorderEventDetail>) {
        console.log("Dragged from index", ev.detail.from, "to", ev.detail.to);

        this.items = ev.detail.complete(this.items);

        console.log("items", this.items);
    }
}
```

## Conversion to Form Control

Custom Value Accessor is a set of functions that allows us to communicate our Custom Form Control with the Angular Forms API so that it always knows what values it has and thus be able to use ngModel or Reactive Forms.

To start, we must import the necessary classes in `app/input-control/input-control.component.ts` these are: `forwardRef`, `ControlValueAccessor` and `NG_VALUE_ACCESSOR`.

```js
import { forwardRef } from "@angular/core";
import { ControlValueAccessor, NG_VALUE_ACCESSOR } from "@angular/forms";
```

The next step is to register the Value Accessor as a provider in our custom form control.

> In useExisting we use forwardRef because our `ReorderControlComponent` does not exist yet. Do not forget to add `multi: true` in case we need to add more providers. Inside the forwardRef goes the class of our component.

```js
@Component({
  selector: 'reorder-control',
  templateUrl: './reorder-control.component.html',
  styleUrls: ['./reorder-control.component.scss'],
  providers: [
    {
      provide: NG_VALUE_ACCESSOR,
      useExisting: forwardRef(() => ReorderControlComponent),
      multi: true,
    },
  ],
})
```

Finally, we have to implement the `ControlValueAccessor` interface that brings its own methods. They will help us to manage the operation of our component as a form control.

-   `writeValue` Gets the value set in an ngModel or ReactiveForm. Useful for when the form already has an initial value.

-   `registerOnChange` Register the onChange function coming from the Reactive Form.

-   `registerOnTouched` Register the onTouched function coming from the Reactive Form.

-   `setDisabledState` Get the disabled state from our Reactive Form.

```js
export class ReorderControlComponent implements OnInit, ControlValueAccessor {
    @Input() items: ReorderItem[];

    disabled: boolean = false;

    onChange = (_: any) => {};
    onTouched = () => {};

    constructor() {}

    ngOnInit() {}

    writeValue(value: number[]): void {
        if (value && value.length) {
            let newItemsOrder = [];

            value.forEach(id => {
                newItemsOrder.push(this.items.find(item => item.value === id));
            });

            this.items = [...newItemsOrder];
        }
    }

    registerOnChange(fn: any): void {
        this.onChange = fn;
    }

    registerOnTouched(fn: any): void {
        this.onTouched = fn;
    }

    setDisabledState(isDisabled: boolean): void {
        this.disabled = isDisabled;
    }

    doReorder(ev: CustomEvent<ItemReorderEventDetail>) {
        this.items = ev.detail.complete(this.items);

        const value = this.items.map(item => item.value);

        this.onTouched();
        this.onChange(value);
    }
}
```

## Testing the Form Control

To test our new control, I created a home page to test all its functions.

```html
<ion-header>
    <ion-toolbar>
        <ion-title>Home</ion-title>
    </ion-toolbar>
</ion-header>

<ion-content>
    <form [formGroup]="homeForm">
        <reorder-control
            formControlName="reorder"
            [items]="items"
        ></reorder-control>
    </form>
</ion-content>
```

```js
import { Component, OnInit } from "@angular/core";
import { FormControl, FormGroup, Validators } from "@angular/forms";

@Component({
    selector: "app-home",
    templateUrl: "./home.page.html",
    styleUrls: ["./home.page.scss"]
})
export class HomePage implements OnInit {
    homeForm: FormGroup;

    items = [
        {
            label: "Item 1",
            value: 1
        },
        {
            label: "Item 2",
            value: 3
        },
        {
            label: "Item 3",
            value: 5
        },
        {
            label: "Item 4",
            value: 7
        }
    ];

    constructor() {}

    ngOnInit() {
        this.homeForm = new FormGroup({
            reorder: new FormControl([5, 3, 1, 7], Validators.required)
        });

        this.homeForm.valueChanges.subscribe(console.log);
    }
}
```

This is how we were able to create a custom form control to extend our Angular forms!

This feature makes it very easy to maintain a data state at the page level, before modifying the App State.

Did I miss something about form controls? Don't forget to leave a comment!
