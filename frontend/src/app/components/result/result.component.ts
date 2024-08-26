import { DecimalPipe, UpperCasePipe } from '@angular/common';
import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { TranslateModule } from '@ngx-translate/core';

@Component({
  selector: 'app-result',
  standalone: true,
  imports: [UpperCasePipe, TranslateModule,DecimalPipe],
  templateUrl: './result.component.html',
  styleUrl: './result.component.css'
})

export class ResultComponent {
  //Extraigo la info de la data final el sessionStorage
  data : any = {};

  constructor(private router: Router){ }

  //Toma los datos de la consulta y lo almacena en el sessionStorage
  ngOnInit(): void {
    const storedData = sessionStorage.getItem('data');
    this.data = storedData ? JSON.parse(storedData) : {};
  }

  //Toma el presupuesto den COP para mostrar en la vista
  budget: string | null = sessionStorage.getItem('budget');

  //Va a la ruta principal y limpia todos los datos del sessionStorage
  home(){
    sessionStorage.clear();
    this.router.navigate(['/']);
  }
}
