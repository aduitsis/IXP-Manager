<?php
declare(strict_types=1);
namespace IXP\Services\LookingGlass;

/*
 * Copyright (C) 2009-2016 Internet Neutral Exchange Association Company Limited By Guarantee.
 * All Rights Reserved.
 *
 * This file is part of IXP Manager.
 *
 * IXP Manager is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation, version v2.0 of the License.
 *
 * IXP Manager is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License v2.0
 * along with IXP Manager.  If not, see:
 *
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

use IXP\Contracts\LookingGlass as LookingGlassContract;

use IXP\Utils\Router;

/**
 * LookingGlass Backend -> Bird's Eye
 *
 * @author     Barry O'Donovan <barry@islandbridgenetworks.ie>
 * @category   LookingGlass
 * @package    IXP\Services\LookingGlass
 * @copyright  Copyright (C) 2009-2016 Internet Neutral Exchange Association Company Limited By Guarantee
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL V2.0
 */
class BirdsEye implements LookingGlassContract {

    /**
     * Instance of a router object representing the looking glass target
     * @var IXP\Utils\Router
     */
    private $router;


    /**
     * Constructor
     * @param Router $r
     */
    public function __construct( Router $r ) {
        $this->setRouter($r);
    }

    /**
     * Set the router object
     * @param Router $r
     * @return IXP\Services\LookingGlass\BirdsEye For fluent interfaces
     */
    public function setRouter( Router $r ): LookingGlassContract {
        $this->router = $r;
        return $this;
    }

    /**
     * Get the router object
     * @return IXP\Utils\Router
     */
    public function router(): Router {
        return $this->router;
    }

    /**
     * Get BGP Summary information as JSON
     * @return string
     */
    public function bgpSummary(): string {
        return file_get_contents( $this->router()->api() . '/protocols/bgp' );
    }

    /**
     * Get the router's status as JSON
     * @return string
     */
    public function status(): string {
        return file_get_contents( $this->router()->api() . '/status' );
    }

    /**
     * Get routes for a named routing table (aka. vrf)
     * @param string $table Table name
     * @return string
     */
    public function routesForTable(string $table): string {
        return file_get_contents( $this->router()->api() . '/routes/table/' . urlencode($table) );
    }

    /**
     * Get routes learnt from named protocol (e.g. BGP session)
     * @param string $protocol Protocol name
     * @return string
     */
    public function routesForProtocol(string $protocol): string {
        return file_get_contents( $this->router()->api() . '/routes/protocol/' . urlencode($protocol) );
    }

    /**
     * Get routes exported to named protocol (e.g. BGP session)
     * @param string $protocol Protocol name
     * @return string
     */
    public function routesForExport(string $protocol): string {
        return file_get_contents( $this->router()->api() . '/routes/export/' . urlencode($protocol) );
    }

}
