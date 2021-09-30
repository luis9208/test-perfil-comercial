import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private api: string;
  private accesToken: string;
  private user_id: number;
  private headers: HttpHeaders;
  private obj_header :any;
  constructor(private http: HttpClient) {
    this.api = environment.host;
    this.headers = new HttpHeaders();
    this.headers.set('Content-Type', 'application/json');
    this.obj_header={headers:this.headers};

    if (localStorage.getItem('userData')) {
      const token_str = localStorage.getItem('userData');
      const token_obj = JSON.parse(token_str);
      this.accesToken = token_obj.token;
      this.user_id = token_obj.user;
    } else {
      this.accesToken = '';
      this.user_id = 0;
    }

  }

  /**
   * Servicio de Logueo
   * @param data 
   * @returns 
   */
  login(data: JSON) {
    let url = this.api.concat('login');
    return this.http.post(url, data, this.obj_header);
  }

  logout() {
    let url = this.api.concat('logout');
    localStorage.clear();
    return this.http.post(url, {}, this.obj_header);
  }

  search(data: any) {
    // headers = headers.set('Content-Type', 'application/json');
    let url = this.api.concat('users/search');

    return this.http.post(url, data, this.obj_header);
  }

  loadFile(data: FormData) {
    let url = this.api.concat('admin/import');
    this.headers.set('Content-Type', 'application/x-www-form-urlencoded')
    return this.http.post(url, data, this.obj_header);
  }

  /**
   * Obtiene el valor del token 
   * almacenado en localStorage
   */
  get accessToken() {
    return this.accesToken;
  }

  /**
   * Devuelve el valor del Id_usuario
   * que esta almacenado en LocalStorage
   */
  get user() {
    return this.user_id;
  }

  //Verifica si el usuario esta logueado
  isLogged(){
    return !!this.accessToken;
  }

}
