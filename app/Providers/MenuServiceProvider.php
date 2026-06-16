<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  public function boot(): void
  {
    View::composer('*', function ($view) {
      $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
      $verticalMenuData = json_decode($verticalMenuJson, true);

      if (Auth::check()) {
        $perfilId = Auth::user()->usuario_perfil_id;

        foreach ($verticalMenuData['menu'] as $key => &$item) {
          if (isset($item['menuHeader'])) {
            continue;
          }

          if (isset($item['perfiles']) && !in_array($perfilId, $item['perfiles'])) {
            unset($verticalMenuData['menu'][$key]);
            continue;
          }

          if (isset($item['submenu'])) {
            $item['submenu'] = array_values(array_filter(
              $item['submenu'],
              function ($subItem) use ($perfilId) {
                if (!isset($subItem['perfiles'])) {
                  return true;
                }
                return in_array($perfilId, $subItem['perfiles']);
              }
            ));

            if (empty($item['submenu'])) {
              unset($verticalMenuData['menu'][$key]);
            }
          }
        }

        $verticalMenuData['menu'] = array_values($verticalMenuData['menu']);
      }
      $verticalMenuData = json_decode(json_encode($verticalMenuData));
      $view->with('menuData', [$verticalMenuData]);
    });
  }
}
