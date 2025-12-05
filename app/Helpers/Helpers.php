<?php

namespace App\Helpers;

use Config;
use Illuminate\Support\Facades\Http;
# uses para generar excel
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\DB;

class Helpers
{
  public static function appClasses()
  {

    $data = config('custom.custom');


    // default data array
    $DefaultData = [
      'myLayout' => 'vertical',
      'myTheme' => 'theme-default',
      'myStyle' => 'light',
      'myRTLSupport' => true,
      'myRTLMode' => true,
      'hasCustomizer' => true,
      'showDropdownOnHover' => true,
      'displayCustomizer' => true,
      'menuFixed' => true,
      'menuCollapsed' => false,
      'navbarFixed' => true,
      'footerFixed' => false,
      'menuFlipped' => false,
      // 'menuOffcanvas' => false,
      'customizerControls' => [
        'rtl',
        'style',
        'layoutType',
        'showDropdownOnHover',
        'layoutNavbarFixed',
        'layoutFooterFixed',
        'themes',
      ],
      //   'defaultLanguage'=>'en',
    ];

    // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
    $data = array_merge($DefaultData, $data);

    // All options available in the template
    $allOptions = [
      'myLayout' => ['vertical', 'horizontal', 'blank'],
      'menuCollapsed' => [true, false],
      'hasCustomizer' => [true, false],
      'showDropdownOnHover' => [true, false],
      'displayCustomizer' => [true, false],
      'myStyle' => ['light', 'dark'],
      'myTheme' => ['theme-default', 'theme-bordered', 'theme-semi-dark'],
      'myRTLSupport' => [true, false],
      'myRTLMode' => [true, false],
      'menuFixed' => [true, false],
      'navbarFixed' => [true, false],
      'footerFixed' => [true, false],
      'menuFlipped' => [true, false],
      // 'menuOffcanvas' => [true, false],
      'customizerControls' => [],
      // 'defaultLanguage'=>array('en'=>'en','fr'=>'fr','de'=>'de','pt'=>'pt'),
    ];

    //if myLayout value empty or not match with default options in custom.php config file then set a default value
    foreach ($allOptions as $key => $value) {
      if (array_key_exists($key, $DefaultData)) {
        if (gettype($DefaultData[$key]) === gettype($data[$key])) {
          // data key should be string
          if (is_string($data[$key])) {
            // data key should not be empty
            if (isset($data[$key]) && $data[$key] !== null) {
              // data key should not be exist inside allOptions array's sub array
              if (!array_key_exists($data[$key], $value)) {
                // ensure that passed value should be match with any of allOptions array value
                $result = array_search($data[$key], $value, 'strict');
                if (empty($result) && $result !== 0) {
                  $data[$key] = $DefaultData[$key];
                }
              }
            } else {
              // if data key not set or
              $data[$key] = $DefaultData[$key];
            }
          }
        } else {
          $data[$key] = $DefaultData[$key];
        }
      }
    }
    //layout classes
    $layoutClasses = [
      'layout' => $data['myLayout'],
      'theme' => $data['myTheme'],
      'style' => $data['myStyle'],
      'rtlSupport' => $data['myRTLSupport'],
      'rtlMode' => $data['myRTLMode'],
      'textDirection' => $data['myRTLMode'],
      'menuCollapsed' => $data['menuCollapsed'],
      'hasCustomizer' => $data['hasCustomizer'],
      'showDropdownOnHover' => $data['showDropdownOnHover'],
      'displayCustomizer' => $data['displayCustomizer'],
      'menuFixed' => $data['menuFixed'],
      'navbarFixed' => $data['navbarFixed'],
      'footerFixed' => $data['footerFixed'],
      'menuFlipped' => $data['menuFlipped'],
      // 'menuOffcanvas' => $data['menuOffcanvas'],
      'customizerControls' => $data['customizerControls'],
    ];

    // sidebar Collapsed
    if ($layoutClasses['menuCollapsed'] == true) {
      $layoutClasses['menuCollapsed'] = 'layout-menu-collapsed';
    }

    // Menu Fixed
    if ($layoutClasses['menuFixed'] == true) {
      $layoutClasses['menuFixed'] = 'layout-menu-fixed';
    }

    // Navbar Fixed
    if ($layoutClasses['navbarFixed'] == true) {
      $layoutClasses['navbarFixed'] = 'layout-navbar-fixed';
    }

    // Footer Fixed
    if ($layoutClasses['footerFixed'] == true) {
      $layoutClasses['footerFixed'] = 'layout-footer-fixed';
    }

    // Menu Flipped
    if ($layoutClasses['menuFlipped'] == true) {
      $layoutClasses['menuFlipped'] = 'layout-menu-flipped';
    }

    // Menu Offcanvas
    // if ($layoutClasses['menuOffcanvas'] == true) {
    //   $layoutClasses['menuOffcanvas'] = 'layout-menu-offcanvas';
    // }

    // RTL Supported template
    if ($layoutClasses['rtlSupport'] == true) {
      $layoutClasses['rtlSupport'] = '/rtl';
    }

    // RTL Layout/Mode
    if ($layoutClasses['rtlMode'] == true) {
      $layoutClasses['rtlMode'] = 'rtl';
      $layoutClasses['textDirection'] = 'rtl';
    } else {
      $layoutClasses['rtlMode'] = 'ltr';
      $layoutClasses['textDirection'] = 'ltr';
    }

    // Show DropdownOnHover for Horizontal Menu
    if ($layoutClasses['showDropdownOnHover'] == true) {
      $layoutClasses['showDropdownOnHover'] = 'true';
    } else {
      $layoutClasses['showDropdownOnHover'] = 'false';
    }

    // To hide/show display customizer UI, not js
    if ($layoutClasses['displayCustomizer'] == true) {
      $layoutClasses['displayCustomizer'] = 'true';
    } else {
      $layoutClasses['displayCustomizer'] = 'false';
    }

    return $layoutClasses;
  }

  public static function updatePageConfig($pageConfigs)
  {
    $demo = 'custom';
    if (isset($pageConfigs)) {
      if (count($pageConfigs) > 0) {
        foreach ($pageConfigs as $config => $val) {
          Config::set('custom.' . $demo . '.' . $config, $val);
        }
      }
    }
  }

  public static function obtenerToken()
  {
    $loginUrl = env('API_GENERA_TOKEN');

    $response = Http::withoutVerifying()->post($loginUrl, [
        'username' => env('API_RHPAY_USER'),
        'password' => env('API_RHPAY_PASS')
    ]);

    if (!$response->successful()) {
        return null;
    }

    $json = $response->json();

    return $json['token'] ?? null;
  }

  /**
   * Genera el array de selects (DB::raw) a partir del mapa de columnas.
   * Devuelve un array listo para ->select().
   */
  public static function buildSelect(array $columnas, array $mapaColumnas): array
  {
      $select = [];
      foreach ($columnas as $col) {
          if (isset($mapaColumnas[$col])) {
              $select[] = DB::raw($mapaColumnas[$col]);
          }
      }
      return $select;
  }

  /**
   * Inserta logo y la información del reporte en las filas 1-3.
   *
   * @param Worksheet $sheet
   * @param array $columnas
   * @param array $registros
   * @param string|null $logoPath
  */
  public static function insertLogoAndInfo(Worksheet $sheet, array $columnas, array $registros, ?string $logoPath = null)
  {
    $totalColumnas = count($columnas);
    $ultimaColumna = Coordinate::stringFromColumnIndex($totalColumnas);

    # Alturas del encabezado
    $sheet->getRowDimension(1)->setRowHeight(30);
    $sheet->getRowDimension(2)->setRowHeight(30);

    # Merge celda del logo para A1:A2
    $sheet->mergeCells("A1:A2");

    # Insertar logo si existe
    if ($logoPath && file_exists($logoPath)) {
      $drawing = new Drawing();
      $drawing->setName('Logo AGZ');
      $drawing->setPath($logoPath);

      # Tamaño cm -> px aproximado
      $drawing->setHeight(2.23 * 37.795);  # alto
      $drawing->setWidth(2.88 * 37.795);   # ancho

      $drawing->setCoordinates('A1');
      $drawing->setOffsetX(5);
      $drawing->setOffsetY(5);
      $drawing->setWorksheet($sheet);
    }

    # Datos del reporte (usuario y hora)
    $usuario   = auth()->user()->nombre . ' ' . auth()->user()->apellido_paterno . ' ' . auth()->user()->apellido_materno;
    $fechaHora = date('Y-m-d H:i:s');

    # Renglón 1 y 2 (merge de B1:ultimaColumna1 y B2:ultimaColumna2)
    $sheet->mergeCells("B1:{$ultimaColumna}1");
    $sheet->setCellValue("B1", "Reporte generado por: $usuario");

    $sheet->mergeCells("B2:{$ultimaColumna}2");
    $sheet->setCellValue("B2", "Hora de generación: $fechaHora");

    # Estilos de los primeros 3 renglones
    $sheet->getStyle("B1:{$ultimaColumna}3")->applyFromArray([
      'font' => [
        'bold' => true,
        'size' => 11,
        'color' => ['rgb' => '000000']
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical'   => Alignment::VERTICAL_CENTER,
        'wrapText'   => true
      ]
    ]);
  }

  /**
   * Escribe los encabezados (fila específica).
   *
   * @param Worksheet $sheet
   * @param array $columnas
   * @param int $row (por defecto 3)
   */
  public static function writeHeaders(Worksheet $sheet, array $columnas, int $row = 3)
  {
    $styleHeader = [
      'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
      ],
      'borders' => [
        'allBorders' => [
          'borderStyle' => Border::BORDER_THIN,
          'color' => ['rgb' => '000000']
        ]
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '005F32']
      ]
    ];

    foreach ($columnas as $i => $titulo) {
      $col = Coordinate::stringFromColumnIndex($i + 1) . $row;
      $sheet->setCellValue($col, strtoupper($titulo));
      $sheet->getStyle($col)->applyFromArray($styleHeader);
      $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i + 1))->setAutoSize(true);
    }
  }

  /**
   * Escribe los datos en las filas, empezando en $startRow (por defecto 4).
   * Aplica bordes y alineación por celda.
   *
   * @param Worksheet $sheet
   * @param array $columnas
   * @param array $registros
   * @param int $startRow
   * @return int Última fila escrita + 1 (útil para calcular ultFila externamente)
   */
  public static function writeData(Worksheet $sheet, array $columnas, array $registros, int $startRow = 4): int
  {
    $fila = $startRow;
    foreach ($registros as $reg) {
      $colIndex = 1;
      foreach ($columnas as $campo) {
        $valor = $reg->$campo ?? '';
        $col = Coordinate::stringFromColumnIndex($colIndex);
        $sheet->setCellValue("{$col}{$fila}", $valor);

        # Bordes y alineación.
        $sheet->getStyle("{$col}{$fila}")->applyFromArray([
          'borders' => [
            'allBorders' => [
              'borderStyle' => Border::BORDER_THIN,
              'color' => ['rgb' => '000000']
            ]
          ],
          'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
        ]);
        $colIndex++;
      }
      $fila++;
    }
    # devuelve la fila siguiente a la última escrita.
    return $fila;
  }

  /**
   * Realiza el merge vertical de celdas que tengan el mismo valor consecutivo por columna.
   *
   * @param Worksheet $sheet
   * @param array $columnas
   * @param int $startRow
   */
  public static function mergeIdenticalColumns(Worksheet $sheet, array $columnas, int $startRow = 2)
  {
    $ultimaFila = $sheet->getHighestRow();
    $totalColumnas = count($columnas);

    for ($colIndex = 1; $colIndex <= $totalColumnas; $colIndex++) {
      $col = Coordinate::stringFromColumnIndex($colIndex);

      $inicio = $startRow;
      $valorAnterior = $sheet->getCell("{$col}{$startRow}")->getValue();

      for ($filaActual = $startRow + 1; $filaActual <= $ultimaFila; $filaActual++) {
        $valorActual = $sheet->getCell("{$col}{$filaActual}")->getValue();
        if ($valorActual !== $valorAnterior) {
          if ($filaActual - 1 > $inicio) {
            $sheet->mergeCells("{$col}{$inicio}:{$col}" . ($filaActual - 1));
            $sheet->getStyle("{$col}{$inicio}")
              ->getAlignment()
              ->setVertical(Alignment::VERTICAL_CENTER);
          }
          $inicio = $filaActual;
          $valorAnterior = $valorActual;
        }
      }
      if ($ultimaFila > $inicio) {
        $sheet->mergeCells("{$col}{$inicio}:{$col}{$ultimaFila}");
        $sheet->getStyle("{$col}{$inicio}")
          ->getAlignment()
          ->setVertical(Alignment::VERTICAL_CENTER);
      }
    }
  }
}
