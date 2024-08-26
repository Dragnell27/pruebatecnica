import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { TranslateModule } from '@ngx-translate/core';
import { environment } from '../../../environments/environment';

declare var $: any;

@Component({
  selector: 'app-budget',
  standalone: true,
  imports: [TranslateModule],
  templateUrl: './budget.component.html',
  styleUrl: './budget.component.css'
})
export class BudgetComponent implements OnInit {

  constructor(private router: Router) { }

  //Defino una variable para usar el endPoint
  private endPoint = environment.apiUrl;

  //Detecta si hubo cambios en el input del presupuesto y los almacena en el sessionStorage
  changeBudget(event: Event) {
    const budget = event.target as HTMLInputElement;
    sessionStorage.setItem('budget', budget.value);
  }

  //Valida si existe un presupuesto en e sessionStorage y lo asigna.
  ngOnInit(): void {
    setTimeout(() => {
      let budget = document.getElementById('budget') as HTMLSelectElement | null;
      if (budget) {
        const storedValue = sessionStorage.getItem('budget') || '0';
        budget.value = storedValue;
      }
    }, 0);
  }

  next(event: Event) {
    const btn_budget = document.getElementById('budget-event');
    const btn_span = document.getElementById('budget-load');
    const alert = document.getElementById('p-alert');
    const budget = parseFloat(sessionStorage.getItem('budget') || '0');

    // Función para mostrar la alerta
    const showAlert = () => {
      if (alert) {
        alert.classList.remove('p-alert-close');
        alert.classList.add('p-alert-open');
        setTimeout(() => {
          alert.classList.remove('p-alert-open');
          alert.classList.add('p-alert-close');
        }, 1500);
      }
    };

    // Verifica si el valor del presupuesto es inválido
    if (budget === 0) {
      showAlert();
      return;
    }

    //open: loader del botón siguiente
    btn_budget?.classList.add('loader');
    btn_span?.classList.add('d-none');

    //Declaro un json el cual contiene la información necesarias para las APIs de clima y moneda
    const formData: { city: string | null, country: string | null, budget: string | null } = {
      city: sessionStorage.getItem('city'),
      country: sessionStorage.getItem('country'),
      budget: sessionStorage.getItem('budget'),
    };

    //Realiza consulta a las APIs
    $.ajax({
      url: `${this.endPoint}/calculator`,
      type: 'POST',
      data: formData,
      success: (data: any) => {
        //Toma la información de que responda y la almacena en el sessionStorage
        sessionStorage.setItem('data', JSON.stringify(data.data));

        //close: loader del botón siguiente
        btn_budget?.classList.remove('loader');
        btn_span?.classList.remove('d-none');

        //Navega a la ruta del resultado.
        this.router.navigate(['/result']);
      },
      error: (jqXHR: any, textStatus: string, errorThrown: string | Error) => {
        console.error('Error:', textStatus, errorThrown);
      }
    });
  }

  //Evento para volver a la ruta principal
  back($event: Event) {
    this.router.navigate(['/']);
  }
}
