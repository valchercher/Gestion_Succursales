import { Component, OnInit } from '@angular/core';
import { AuthService } from '../service/auth.service';
import { User } from '../shared/utilisateur.interface';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent  implements OnInit{
userConnecter?:User
  constructor(private authService:AuthService){}
  ngOnInit(): void {
 this.getUser()
  }
  seDeconnecter(){
    this.authService.deconnecter().subscribe({
      next:(response=>{
        console.log(response);
        
      })
    })
  }
  getUser(){
    let user=localStorage.getItem('user')?.toString()
    this.userConnecter=JSON.parse(user!);
  }
}
