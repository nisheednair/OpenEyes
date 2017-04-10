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

var OpenEyes = OpenEyes || {};

OpenEyes.OphCiExamination = OpenEyes.OphCiExamination || {};

OpenEyes.OphCiExamination.EyedrawObserver = (function() {
    "use strict";
    var instance;
    var _disorders = {};
    var _consolidatedDisorders = {};

    /**
     * Carries out the call to update disorders
     */
    function updateDisorders()
    {
        var consolidated = consolidateDisorders();
        if (consolidated != _consolidatedDisorders) {
            if (!$('#OphCiExamination_diagnoses').length) {
                alert('No diagnosis element');
            } else {
                var controller = $('#OphCiExamination_diagnoses').data('controller');
                controller.setEyedrawDiagnoses(consolidated);
            }
            _consolidatedDisorders = consolidated;
        }
    }

    function consolidateDisorders()
    {
        var consolidated = {};
        for (var source in _disorders) {
            if (_disorders.hasOwnProperty(source)) {
                var side = source.side;
                for (var disorder in _disorders[source]) {
                    if (consolidated.hasOwnProperty(disorder)) {
                        consolidated[disorder]['sources'].append(source);
                        if (!side in consolidated[disorder]['sides']) {
                            consolidated[disorder]['sides'].append(side);
                        }
                    } else {
                        consolidated[disorder] = {
                            'source': [source],
                            'sides': [side]
                        }
                    }
                }
            }
        }
        return consolidated;
    }

    function EyedrawObserver()
    {
        if (instance) {
            return instance;
        }
        instance = this;
    }

    EyedrawObserver.prototype.setDisordersForSource = function(source, disorders)
    {
        _disorders[source] = disorders;
        updateDisorders();
    };

    return EyedrawObserver;
})();
