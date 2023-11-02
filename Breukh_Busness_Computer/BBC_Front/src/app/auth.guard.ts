import {  inject } from '@angular/core';
import { AuthService } from './service/auth.service';
import { ActivatedRouteSnapshot, CanActivateFn, Router, RouterStateSnapshot } from '@angular/router';
import { of } from 'rxjs';

export const authGuard: CanActivateFn = (
  route:ActivatedRouteSnapshot,
   state:RouterStateSnapshot
   ) => {
     const router=inject(Router);
     const service=inject(AuthService);
     const user= JSON.parse(service.getUser()!);
        if (service.estConnecte()) {
          return true; 
        } else {
          
          router.navigate(['']);
          return false; 
        }
      
};
