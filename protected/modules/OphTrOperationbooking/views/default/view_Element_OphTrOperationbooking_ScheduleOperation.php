<?php
/**
 * OpenEyes.
*
* (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
* (C) OpenEyes Foundation, 2011-2013
* This file is part of OpenEyes.
* OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
* OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
* You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
*
* @link http://www.openeyes.org.uk
*
* @author OpenEyes <info@openeyes.org.uk>
* @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
* @copyright Copyright (c) 2011-2013, OpenEyes Foundation
* @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
*/
?>

<section class="element element-data">
	<h3 class="data-title"><?= $element->elementType->name; ?></h3>
	<div class="data-value"><?= $element->schedule_options->name; ?></div>
	<div class="row">
		<div class="large-6 column">
			<h3 class="data-title"><?php echo $element->getAttributeLabel('patient_unavailables') ?></h3>
			<div class="data-value">
				<?php if ($element->patient_unavailables) {
                    foreach ($element->patient_unavailables as $unavailable) {?>
						<div class="data-row">
							<?php echo Helper::convertDate2NHS($unavailable->start_date); ?> to <?php echo Helper::convertDate2NHS($unavailable->end_date); ?> (<?php echo $unavailable->reason->name ?>).
						</div>
					<?php }
                } else { ?>
					No known availability restrictions.
				<?php } ?>
			</div>
		</div>
	</div>
</section>

