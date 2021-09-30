import { HttpErrorResponse, HttpHandler, HttpHeaderResponse, HttpInterceptor, HttpProgressEvent, HttpRequest, HttpResponse, HttpSentEvent, HttpUserEvent, HttpEvent } from '@angular/common/http';
import { CATCH_ERROR_VAR } from '@angular/compiler/src/output/output_ast';
import { Injectable, Injector } from '@angular/core';
import { Router } from '@angular/router';
import { BehaviorSubject, Observable, throwError } from 'rxjs';
import { take, filter, catchError, switchMap, finalize, tap } from 'rxjs/operators';

import { AuthService } from '../services/auth.service';

@Injectable({
  providedIn: 'root'
})
export class RequestInterceptor implements HttpInterceptor {

  // private tokenSubject: BehaviorSubject<string> = new BehaviorSubject<string>(null);
  private authService: AuthService;

  constructor(private injector: Injector, private router: Router) {

    this.authService = this.injector.get(AuthService);

  }

  intercept(req: HttpRequest<any>, next: HttpHandler):
    Observable<HttpSentEvent | HttpHeaderResponse | HttpProgressEvent | HttpResponse<any> | HttpUserEvent<any>> {
    const token = this.authService.accessToken;


    if (token) {
      return next.handle(this.addToken(req, token)).pipe(
        tap(event => {
          if (event instanceof HttpResponse) {
            this.router.navigate(['/dashboard']);

          }
        }, error => {
          return this.logoutUser();
        }));
    }
    this.router.navigate(['/dashboard']);
    return next.handle(req);
  }

  addToken(req: HttpRequest<any>, token: string): HttpRequest<any> {
    return req.clone({ setHeaders: { Authorization: 'Bearer '.concat(token) } });
  }

  logoutUser() {
    this.authService.logout();
    this.router.navigate(['/login'], { queryParams: { returnUrl: this.router.url } });
    // Route to the login page (implementation up to you)
    return throwError('');
  }
}
