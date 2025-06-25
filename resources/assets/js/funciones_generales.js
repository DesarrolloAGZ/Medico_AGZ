// Funcion de pantalla de carga
function pantallaCarga(accion) {
  if (accion == 'on') {
    $('#pantallaDeCarga').css('display', 'grid');
  } else {
    $('#pantallaDeCarga').css('display', 'none');
  }
}

// Funcion para mostrar el grafico de total de consultas por ultimos 8 dias
function verGraficoConsultasPorDia(datos_vista) {
  // Configuración de colores
  const borderColor = '#828393';
  const labelColor = '#828393';
  const config = { colors: { info: '#006c39' } };

  // Procesa datos para el gráfico
  const categories = datos_vista.map(item => item.dia);
  const seriesData = datos_vista.map(item => parseInt(item.cantidad_consultas));

  // Calcula máximo y mínimo
  const maxDataValue = Math.max(...seriesData);
  const minDataValue = Math.min(...seriesData);

  // Ajusta el máximo para que sea un número entero redondeado
  const maxX = Math.ceil(maxDataValue * 1.1);
  const minX = Math.max(0, Math.floor(minDataValue * 0.9));

  // Inicialización del gráfico
  document.addEventListener('DOMContentLoaded', function () {
    const horizontalBarChartEl = document.querySelector('#horizontalBarChart');

    const horizontalBarChartConfig = {
      chart: {
        height: 343,
        fontFamily: 'Inter',
        type: 'bar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          horizontal: true,
          barHeight: '30%',
          borderRadius: 8,
          borderRadiusApplication: 'end',
          borderRadiusWhenStacked: 'last'
        }
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: false
          }
        },
        padding: {
          top: -20,
          bottom: -12
        }
      },
      colors: [config.colors.info],
      dataLabels: {
        enabled: false,
        formatter: function (val) {
          return Math.round(val);
        }
      },
      series: [
        {
          name: 'Consultas',
          data: seriesData
        }
      ],
      xaxis: {
        min: minX,
        max: maxX,
        tickAmount: 4,
        categories: categories,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          },
          formatter: function (val) {
            return Math.round(val); // Asegurar números en eje X
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        }
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return Math.round(val) + (val === 1 ? ' consulta' : ' consultas'); // tooltip
          }
        }
      }
    };
    if (horizontalBarChartEl) {
      const horizontalBarChart = new ApexCharts(horizontalBarChartEl, horizontalBarChartConfig);
      horizontalBarChart.render();
    }
  });
}
