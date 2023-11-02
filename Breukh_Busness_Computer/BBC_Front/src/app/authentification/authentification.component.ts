import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../service/auth.service';
import { User, response } from '../shared/utilisateur.interface';

@Component({
  selector: 'app-authentification',
  templateUrl: './authentification.component.html',
  styleUrls: ['./authentification.component.css']
})
export class AuthentificationComponent  implements OnInit{
  message?:string
  loginForm:FormGroup;
  isSubmit:boolean=false;
  user?:User;
  loading:boolean=true
  constructor(private authService: AuthService,
    private router: Router,private fb:FormBuilder){

    this.loginForm=this.fb.group({
      email:['',[Validators.required]],
      password:['',[Validators.required]],
    })
  }
  ngOnInit(): void {
    setTimeout(()=>{
      this.loading=false
    },4000)
  }
  get formControls() {
     return this.loginForm.controls;
     }
  get token(){
    return localStorage.getItem('ACCESS_TOKEN')
  }
  seConnecter(){
    console.log(this.loginForm.value);
    this.isSubmit= true;
    if(this.loginForm.invalid){
      return;
    }
    this.authService.seConnecter(this.loginForm.value).subscribe(
      (response:response)=>{
        if(response.status===200){
          localStorage.setItem('ACCESS_TOKEN',response.token);
          this.user=response.user  
          localStorage.setItem('user',JSON.stringify(response.user))
          this.router.navigateByUrl('/produit/lister');
          console.log(this.token);

        }
        this.message=response.message
    },(error) => {
     
      console.error('Erreur : ', error.error.message);
      this.message=error.error.message
      
    });
  }
  seDeconnecter(){
    this.authService.deconnecter();
    this.router.navigateByUrl('/connexion');
  }



 
}
