import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor,
  HTTP_INTERCEPTORS
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { AuthService } from './service/auth.service';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {

  constructor(private authservice:AuthService) {}
  
  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
   request= request.clone({    
      headers:request.headers.set('Authorization',`Bearer ${this.authservice.token!}`)
    })
    return next.handle(request);
  }
}
export  const AuthInterceptorProvider={
  provide:HTTP_INTERCEPTORS,
  useClass:AuthInterceptor,
  multi:true
}
