<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Policies;

use Playground\Auth\Policies\ModelPolicy;

/**
 * \Playground\Matrix\Api\Policies\FlowPolicy
 */
class FlowPolicy extends ModelPolicy
{
    protected string $package = 'playground-matrix-api';

    /**
     * @var array<int, string> The roles allowed to view the MVC.
     */
    protected $rolesToView = [
        'user',
        'staff',
        'publisher',
        'manager',
        'admin',
        'root',
    ];

    /**
     * @var array<int, string> The roles allowed for actions in the MVC.
     */
    protected $rolesForAction = [
        'publisher',
        'manager',
        'admin',
        'root',
    ];
}
