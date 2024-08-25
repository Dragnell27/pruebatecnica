import { Routes } from '@angular/router';
import { LocationComponent } from './components/location/location.component';
import { BudgetComponent } from './components/budget/budget.component';
import { ResultComponent } from './components/result/result.component';

export const routes: Routes = [
  {path: '', component: LocationComponent},
  {path: 'budget', component: BudgetComponent},
  {path: 'result', component: ResultComponent},
];
