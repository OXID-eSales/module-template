#!/bin/bash

SCRIPT_PATH=$(dirname ${BASH_SOURCE[0]})
cd $SCRIPT_PATH/.. || exit

projectname_original='oxid-esales/module-template'
vendor_original='OxidEsales'
module_original='ModuleTemplate'
moduleid_original='oe_moduletemplate'
company_original='OXID eSales AG'
metadata_title_original='OxidEsales Module Template'
namespace_original='OxidEsales\\ModuleTemplate'
target_directory_original='oe/moduletemplate'

echo
echo "In order to convert this module template to your own, you will be asked for some information."
echo
echo "Please enter project name (original: $projectname_original):"
read projectname
perl -pi -e "s#$projectname_original#$projectname#g;"  ./composer.json
echo

echo "Please enter vendor (original: $vendor_original):"
read vendor
perl -pi -e "s#$vendor_original#$vendor#g;"  ./composer.json
echo

echo "Please enter module namespace (original: $module_original):"
read module
perl -pi -e "s#$module_original#$module#g;"  ./composer.json
echo

echo "Please enter module id (original: $moduleid_original)"
read moduleid
find . -type f \( ! -name "personalize.sh" \) -exec grep -l "$moduleid_original" {} \; |xargs perl -pi -e "s#$moduleid_original#$moduleid#g;"
perl -pi -e "s#$company_original#$vendor#g;"  ./metadata.php
perl -pi -e "s#$metadata_title_original#CHANGE MY TITLE#g;"  ./metadata.php
echo

#File headers
echo "Please enter company name (original: $company_original)"
read company
find . -type f \( ! -name "personalize.sh" \) -exec grep -l "$company_original" {} \; |xargs perl -pi -e "s#$company_original#$company#g;"

#target directory
target_directory="$(echo $vendor | tr '[:upper:]' '[:lower:]')/$(echo $module | tr '[:upper:]' '[:lower:]')"
perl -pi -e "s#$target_directory_original#$target_directory#g;"  ./composer.json
perl -pi -e "s#$target_directory_original#$target_directory#g;"  ./metadata.php
perl -pi -e "s#$target_directory_original#$target_directory#g;"  ./tests/Codeception/acceptance.suite.yml

#namespace
namespace="${vendor}\\\\${module}"
find . -type f \( ! -name "personalize.sh" \) -exec grep -l "$namespace_original" {} \; |xargs perl -pi -e "s#$namespace_original#$namespace#g;"

echo
echo 'Please commit the changes. Your module is now ready to go and be adapted to your needs.'