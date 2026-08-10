<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Event;
use Bitrix\Main\EventResult;

class ProductBadgeManager
{
    private static $instance;
    private $badgeRules = [];
    private $badgePriority = [];
    
    private function __construct()
    {
        $this->initDefaultRules();
    }
    
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Получить бейджи для товара
     */
    public function getBadges($item)
    {
        $badges = [];
        $props = $item['PROPERTIES'] ?? [];
        
        foreach ($this->badgeRules as $rule) {
            $propCode = $rule['property'];
            
            if (!empty($props[$propCode]['VALUE'])) {
                $badge = $this->processBadge($props[$propCode]['VALUE'], $rule);
                if ($badge) {
                    $badge['priority'] = $rule['priority'];
                    $badges[] = $badge;
                }
            }
        }
        
        // Сортируем по приоритету
        usort($badges, function($a, $b) {
            return $b['priority'] <=> $a['priority'];
        });
        
        // Отправляем событие для модификации бейджей
        $event = new Event('main', 'onAfterGetProductBadges', [
            'item' => $item,
            'badges' => $badges
        ]);
        $event->send();
        
        foreach ($event->getResults() as $result) {
            if ($result->getType() === EventResult::SUCCESS) {
                $data = $result->getParameters();
                if (isset($data['badges'])) {
                    $badges = $data['badges'];
                }
            }
        }
        
        return [
            'MAIN_BADGE' => !empty($badges) ? $badges[0] : null,
            'ADDITIONAL_BADGES' => array_slice($badges, 1),
            'ALL_BADGES' => $badges,
            'HAS_BADGE' => !empty($badges),
            'COUNT' => count($badges)
        ];
    }
    
    /**
     * Получить только основной бейдж
     */
    public function getMainBadge($item)
    {
        $badges = $this->getBadges($item);
        return $badges['MAIN_BADGE'];
    }
    
    /**
     * Проверить наличие конкретного типа бейджа
     */
    public function hasBadgeType($item, $type)
    {
        $badges = $this->getBadges($item);
        foreach ($badges['ALL_BADGES'] as $badge) {
            if ($badge['type'] === $type) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Получить CSS классы для товара (для обертки)
     */
    public function getBadgeCssClasses($item)
    {
        $classes = [];
        $badges = $this->getBadges($item);
        
        foreach ($badges['ALL_BADGES'] as $badge) {
            $classes[] = 'has-badge-' . $badge['type'];
        }
        
        return implode(' ', $classes);
    }
    
    private function initDefaultRules()
    {
        // Акция - самый высокий приоритет
        $this->addRule([
            'property' => 'AKTSIYA_',
            'priority' => 100,
            'callback' => function($value) {
                return [
                    'class' => 'badge--sale',
                    'text' => 'Акция ' . intval($value) . '%',
                    'type' => 'sale'
                ];
            }
        ]);
        
        // Рейтинг продаж
        $this->addRule([
            'property' => 'RAITING_PRODAZH',
            'priority' => 90,
            'map' => [
                'Эксклюзив' => ['class' => 'badge--exclusive', 'text' => 'Эксклюзив', 'type' => 'exclusive'],
                'Рекомендуем' => ['class' => 'badge--recomended', 'text' => 'Рекомендуем', 'type' => 'recommended'],
                'Новинка' => ['class' => 'badge--new', 'text' => 'Новинка', 'type' => 'new'],
                'Хит' => ['class' => 'badge--hit', 'text' => 'Хит', 'type' => 'hit'],
            ]
        ]);
        
        // Под заказ
        $this->addRule([
            'property' => 'POD_ZAKAZ',
            'priority' => 50,
            'callback' => function($value) {
                return [
                    'class' => 'badge--order',
                    'text' => 'Под заказ',
                    'type' => 'order'
                ];
            }
        ]);
        
        // Лучшая цена
        $this->addRule([
            'property' => 'TSENA_CHTO_NADO',
            'priority' => 40,
            'callback' => function($value) {
                return [
                    'class' => 'badge--best-price',
                    'text' => 'Лучшая цена',
                    'type' => 'best-price'
                ];
            }
        ]);
    }
    
    /**
     * Добавить правило для бейджа
     */
    public function addRule($rule)
    {
        $this->badgeRules[] = $rule;
    }
    
    /**
     * Установить приоритет для свойства
     */
    public function setPriority($property, $priority)
    {
        foreach ($this->badgeRules as &$rule) {
            if ($rule['property'] === $property) {
                $rule['priority'] = $priority;
            }
        }
    }
    
    private function processBadge($value, $rule)
    {
        if (isset($rule['callback']) && is_callable($rule['callback'])) {
            return $rule['callback']($value);
        }
        
        if (isset($rule['map'][$value])) {
            return $rule['map'][$value];
        }
        
        return null;
    }
}