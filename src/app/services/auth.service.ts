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
  constructor(private http: HttpClient) {
    this.api = environment.host;

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
    return this.http.post(url, data);
  }

  logout() {
    let url = this.api.concat('logout');
    localStorage.clear();
    return this.http.post(url, {});
  }

  search(data: any) {
    // headers = headers.set('Content-Type', 'application/json');
    let url = this.api.concat('users/search');

    return this.http.post(url, data);
  }

  loadFile(data: FormData) {
    let url = this.api.concat('admin/import');
    let headers = new HttpHeaders();
    headers.set('Content-Type', 'application/x-www-form-urlencoded');
    return this.http.post(url, data, {headers});
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
