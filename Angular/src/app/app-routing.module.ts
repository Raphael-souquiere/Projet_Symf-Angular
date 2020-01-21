import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AppComponent } from './app.component';
import { ListeuserComponent } from './listeuser/listeuser.component';
import { HomeComponent } from './home/home.component';
import { RecupdataComponent } from './recupdata/recupdata.component';

const routes: Routes = [
  { path: 'home', component: HomeComponent },
  { path: 'listeuser', component: ListeuserComponent },
  { path: 'recupdata', component: RecupdataComponent }
];
@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
