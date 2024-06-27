#!/bin/bash

SCRIPT_PATH=$(dirname ${BASH_SOURCE[0]})
cd $SCRIPT_PATH/.. || exit

package_name='oxid-esales/module-template'
namespace='OxidEsales\ModuleTemplate'
module_id='oe_moduletemplate'
company='OXID eSales AG'
target_directory='oe/moduletemplate'

echo -e "\nIn order to convert this module template to your own, you will be asked for some information."
echo -e "\nPlease enter package name (original: $package_name):"
read -r package_name_input

perl -pi -e "s#$package_name#$package_name_input#g;" ./composer.json
perl -pi -e "s#$package_name#$package_name_input#g;" ./.github/oxid-esales/module-template.yaml

echo -e "\nPlease enter module namespace (original: $namespace):"
# Prepare original namespace for replacement in composer.json file
namespace=$(echo "$namespace" | perl -pe 's#\\#\\\\\\\\#g')
read -r namespace_input

# Extract vendor name from provided namespace, will be need for later use
vendor_name=$(echo "$namespace_input" | perl -pe 's#([^\\]*).*#\1#g')
# Extract module name from provided namespace, will be need for later use
module_name=$(echo "$namespace_input" | perl -pe 's#.*\\(.*)#\1#g')

# Prepare provided namespace for replacement in composer.json file
namespace_input=$(echo "$namespace_input" | perl -pe 's#\\{1,}#\\\\\\\\#g')
perl -pi -e "s#$namespace#$namespace_input#g;" ./composer.json

# Prepare original namespace for replacement in the module files by handling \ counts
namespace=$(echo "$namespace" | perl -pe 's#\\\\\\\\#\\\\#g')
# Prepare input namespace for replacement in the module files by handling \ counts
namespace_input=$(echo "$namespace_input" | perl -pe 's#\\\\\\\\#\\\\#g')
find . -type f \( ! -name "personalize.sh" -and ! -name "README.md" \) -exec grep -l "$namespace" {} \; |xargs perl -pi -e "s#$namespace#$namespace_input#g;"

services_namespace=$(echo "$namespace" | perl -pe 's#\\\\#\\\\\\\\#g')
services_namespace_input=$(echo "$namespace_input" | perl -pe 's#\\\\#\\\\\\\\#g')
find . -type f \( ! -name "personalize.sh" -and ! -name "README.md" \) -exec grep -l "$services_namespace" {} \; |xargs perl -pi -e "s#$services_namespace#$services_namespace_input#g;"

# Compose module id based on <yourVendorPrefix> and <yourModuleRootDirectory> directories
module_root_directory=${PWD##*/}
vendor_directory_path=$(echo "$PWD" | perl -pe "s#$module_root_directory##g")
vendor_prefix="${vendor_directory_path%"${vendor_directory_path##*[!/]}"}"
vendor_prefix="${vendor_prefix##*/}"
composed_module_id="${vendor_prefix}_${module_root_directory}"
echo -e "\nYour module id is: '$composed_module_id'!"

# Replace module id everywhere except in this file
find . -type f \( ! -name "personalize.sh" -and ! -name "README.md" \) -exec grep -l "$module_id" {} \; |xargs perl -pi -e "s#$module_id#$composed_module_id#g;"

# Change title in metadata.php file
perl -pi -e "s#OxidEsales Module Template \(OEMT\)#CHANGE MY TITLE#g;" ./metadata.php

#File headers
echo -e "\nPlease enter company name (original: $company)"
read company_input
find . -type f \( ! -name "personalize.sh" \) -exec grep -l "$company" {} \; |xargs perl -pi -e "s#$company#$company_input#g;"

#target directory
composed_target_directory="${vendor_prefix}/${module_root_directory}"
perl -pi -e "s#$target_directory#$composed_target_directory#g;" ./composer.json
perl -pi -e "s#$target_directory#$composed_target_directory#g;" ./metadata.php
perl -pi -e "s#$target_directory#$composed_target_directory#g;" ./tests/Codeception/Acceptance.suite.yml
perl -pi -e "s#$target_directory#$composed_target_directory#g;" ./.github/oxid-esales/module-template.yaml

#update acceptance suite
perl -pi -e "s#$package_name#$package_name_input#g;" ./tests/Codeception/Acceptance.suite.yml

# Prepare ./.github/workflows/development.yml file
perl -pi -e "s#project_key: 'OXID-eSales_module-template'#project_key: 'CHANGE SONARCLOUD ORGANIZATION'#g;" ./.github/oxid-esales/module-template.yaml
perl -pi -e "s#organization: 'oxid-esales'#organization: 'CHANGE SONARCLOUD ORGANIZATION'#g;" ./.github/oxid-esales/module-template.yaml

# Prepare ./migration/migrations.yml file
perl -pi -e "s#name: OXID Module Template#name: $vendor_name $module_name#g;" ./migration/migrations.yml

# Prepare ./CHANGELOG.md file
perl -pi -e "s#OXID eShop Module Template#$vendor_name $module_name#g;" ./CHANGELOG.md
perl -0777pi\
  -e 's#(^.*?\#\# \[1\.0\.0\] - Unreleased)(.*?)$#\1#gs'\
  ./CHANGELOG.md

echo -e "Please review and commit the changes. Your module is now ready to go and be adapted to your needs."