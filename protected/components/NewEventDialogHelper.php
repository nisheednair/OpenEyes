<?php
/**
 * OpenEyes.
 *
 * (C) OpenEyes Foundation, 2017
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2017, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

/**
 * Class NewEventDialogHelper
 *
 * Static wrapper class to encapsulate useful functions to structure data for the New Event Dialog
 */
class NewEventDialogHelper
{

    /**
     * @param Episode $episode
     * @return array
     */
    public static function structureEpisode(Episode $episode)
    {
        if ($subspecialty = $episode->getSubspecialty()) {
            $structured_subspecialty = static::structureSubspecialty($subspecialty);
        } else {
            $structured_subspecialty = array(
                'name' => 'Support Services',
                'shortName' => 'SS'
            );
        }
        return array(
            'id' => $episode->id,
            'service' => $episode->firm ? $episode->firm->name : '',
            'subspecialty' => $structured_subspecialty
        );
    }

    /**
     * @param Episode[] $episodes
     * @return array
     */
    public static function structureEpisodes(array $episodes)
    {
        $res = array();
        foreach ($episodes as $ep) {
            $res[] = static::structureEpisode($ep);
        }
        return $res;
    }

    /**
     * @param Subspecialty $subspecialty
     * @return array
     */
    public static function structureSubspecialty(Subspecialty $subspecialty)
    {
        return array(
            'id' => $subspecialty->id,
            'name' => $subspecialty->name,
            'shortName' => $subspecialty->ref_spec
        );
    }

    /**
     * @param Firm $firm
     * @return array
     */
    public static function structureFirm(Firm $firm)
    {
        return array(
            'id' => $firm->id,
            'name' => $firm->name
        );
    }

    /**
     * @return array|bool
     */
    public static function structureAllSubspecialties()
    {
        $subspecialties = Yii::app()->cache->get('new-event-subspecialties');
        if ($subspecialties === false) {
            $subspecialties = array();
            foreach (Subspecialty::model()->findAll() as $subspecialty) {
                $related_firms = Firm::model()
                    ->active()
                    ->with('serviceSubspecialtyAssignment')
                    ->findAll(array(
                        'condition' => 'serviceSubspecialtyAssignment.subspecialty_id = :ssid',
                        'params' => array(':ssid' => $subspecialty->id),
                        'order' => 't.name asc'
                    ));
                if (count($related_firms)) {
                    $structure = static::structureSubspecialty($subspecialty);
                    $firms = array();
                    foreach ($related_firms as $f) {
                        array_push($firms, static::structureFirm($f));
                    }
                    $structure['services'] = $firms;
                    $structure['contexts'] = $firms;
                    array_push($subspecialties, $structure);
                }
            }
            Yii::app()->cache->set('new-event-subspecialties', $subspecialties, 30);
        }

        return $subspecialties;
    }
}