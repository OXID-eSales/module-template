#!/bin/bash

SCRIPT_PATH=$(dirname ${BASH_SOURCE[0]})
cd $SCRIPT_PATH/.. || exit

package_name='oxid-esales/module-template'
namespace='OxidEsales\ModuleTemplate'
module_id='oe_moduletemplate'
company='OXID eSales AG'

echo -e "\nIn order to convert this module template to your own, you will be asked for some information."
echo -e "\nPlease enter package name (original: $package_name):"
read -r package_name_input

perl -pi -e "s#$package_name#$package_name_input#g;" ./composer.json

# Prepare ./.github/workflows/module-template.yaml
perl -pi -e "s#$package_name#$package_name_input#g;" ./.github/oxid-esales/module-template.yaml
perl -pi -e "s#repository: 'OXID-eSales/module-template'#repository: '$package_name_input'#g;" ./.github/oxid-esales/module-template.yaml
perl -pi -e "s#shop_url: '.*?'#shop_url: 'TODO: PUT THE LINK TO MY REPO'#g;" ./.github/oxid-esales/module-template.yaml
perl -pi -e "s#project_key: 'OXID-eSales_module-template'#project_key: 'TODO: CHANGE SONARCLOUD PROJECT KEY'#g;" ./.github/oxid-esales/module-template.yaml
perl -pi -e "s#organization: 'oxid-esales'#organization: 'TODO: CHANGE SONARCLOUD ORGANIZATION'#g;" ./.github/oxid-esales/module-template.yaml

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

echo -e "\nPlease enter module id (original: $module_id):"
read -r composed_module_id

# Replace module id everywhere except in this file
find . -type f \( ! -name "personalize.sh" -and ! -name "README.md" \) -exec grep -l "$module_id" {} \; |xargs perl -pi -e "s#$module_id#$composed_module_id#g;"

# Change title and version in metadata.php file
perl -pi \
  -e "s#OxidEsales Module Template \(OEMT\)#TODO: CHANGE MY TITLE#g;" \
  -e "s/'version'\s*=>\s*'[^']*'/'version' => '1.0.0'/" \
  ./metadata.php

#File headers
echo -e "\nPlease enter company name (original: $company)"
read company_input
find . -type f \( ! -name "personalize.sh" \) -exec grep -l "$company" {} \; |xargs perl -pi -e "s#$company#$company_input#g;"

#update acceptance suite
perl -pi -e "s#$package_name#$package_name_input#g;" ./tests/Codeception/Acceptance.suite.yml

# Prepare ./migration/migrations.yml file
perl -pi -e "s#name: OXID Module Template#name: $vendor_name $module_name#g;" ./migration/migrations.yml

# Prepare ./CHANGELOG.md file
perl -pi -e "s#OXID eShop Module Template#$vendor_name $module_name#g;" ./CHANGELOG.md
perl -0777 -pe 's/^## .*\z/## [v1.0.0] - Unreleased/ms' CHANGELOG.md > CHANGELOG.tmp && mv CHANGELOG.tmp CHANGELOG.md

# Clean the LICENSE file
echo "TODO: Your license content goes here" > ./LICENSE

echo -e "\e[42mYour module is now ready to go and be adapted to your needs. Please review and commit the changes.\e[0m"
echo -e "\e[43mPlease search for TODO text and adjust there!\e[0m"
echo -e "\e[43mRemember to remove the personalization script!\e[0m"
echo -e "\e[43mRemember to update your README and LICENSE files!\e[0m"
