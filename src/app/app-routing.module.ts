import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './components/home/home.component';
import { LoginComponent } from './components/login/login.component';
import { AuthGuard } from './gurds/auth.guard';


const routes: Routes = [
  {path:'login', component:LoginComponent},
  {path:'dashboard', component:HomeComponent, canActivate:[AuthGuard]},
  {path:'subalterno', component:HomeComponent, canActivate:[AuthGuard]},
  {path:'**', redirectTo:'dashboard'}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
