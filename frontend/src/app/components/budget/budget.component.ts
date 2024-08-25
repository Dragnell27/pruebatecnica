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
  private endPoint = environment.apiUrl;

  changeBudget(event: Event) {
    const budget = event.target as HTMLInputElement;
    sessionStorage.setItem('budget', budget.value);
  }

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
    const alert = document.getElementById('p-alert');

    // Obtén los valores de sessionStorage y conviértelos a números
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
    } else {
        const formData: { city: string | null, country: string | null, budget: string | null } = {
            city: sessionStorage.getItem('city'),
            country: sessionStorage.getItem('country'),
            budget: sessionStorage.getItem('budget'),
        };

        $.ajax({
            url: `${this.endPoint}/calculator`, // URL de la ruta a la que enviarás la solicitud
            type: 'POST', // Método HTTP
            data: formData, // Datos a enviar
            success: (data: any) => {
                console.log(data);
                // Navegar a la ruta deseada solo después de que la respuesta de la API haya llegado
                this.router.navigate(['/result']);
            },
            error: (jqXHR: any, textStatus: string, errorThrown: string | Error) => {
                console.error('Error:', textStatus, errorThrown);
                // Aquí podrías manejar errores o mostrar una alerta de error
            }
        });
    }
}

  back($event: Event) {
    this.router.navigate(['/']);
  }
}
