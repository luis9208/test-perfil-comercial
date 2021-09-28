import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { User } from 'src/app/models/User.models';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  user: any
  message: string;
  loadForm: FormGroup;
  select: any;
  constructor(private auth: AuthService, private router: Router, private builder: FormBuilder) {
    this.loadForm = builder.group({
      file:['', Validators.required]
    });
  }

  /**
   * Obtiene los datos del usuario y los subordinados
   */
  private cargardata(){

    const data_user = {id: this.auth.user};    
    this.auth.search(data_user).subscribe({
      next: (data) => {
        this.user = data;
      },
      error: (err)=>{
        this.router.navigate(['login']);
      }
    });
  }

  ngOnInit() {
    this.cargardata();
  }

 perfilSub(id_user){
   this.user = null;  
    this.auth.search({id:id_user}).subscribe(
      {
        next: async (data) => {
          this.user = await data;
          this.router.navigate(['subalterno']);
          
        },
        error:(err) => {
          this.router.navigate(['dashboard']);
        }
      });


  }


  selectFile(target){
    this.select = target.files;
  }

  loadFile(){
    console.log(this.loadForm.value);
    const formData: FormData = new FormData();
    formData.append('file', this.select[0], this.select[0].name);

    this.auth.loadFile(formData).subscribe({
      next:(data:any)=>{
        this.message = data;
      },
      error:(err)=>{
        this.message=err;
      }
    });
  }
}
