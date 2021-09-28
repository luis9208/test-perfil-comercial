import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { stringify } from 'querystring';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  loginForm: FormGroup;
  constructor(private buider: FormBuilder, private router: Router, private auth: AuthService) {
    this.loginForm = this.buider.group({
      email: ['', Validators.required],
      password: ['', Validators.required]
    });

  }

  ngOnInit() {
  }

  onSubmit(form) {
    this.auth.login(this.loginForm.value).subscribe({
      next: (data:any) => {
        localStorage.setItem('userData', JSON.stringify(data.message));
        this.router.navigate(['dashboard']);
      },
      error: (err) => {
        console.log(err.message);
        
      }
    })
  }

}
