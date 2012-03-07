# @package	Joomla.Site
# @subpackage  mod_doyandexmetrika
# @author	Sergey Donin
# @author mail	sergey.donin@gmail.com

TYPE = 'mod_'
# NAME must be equal to filename of main XML file!
NAME = 'doyandexmetrika'
PREFIX = .
DIST_DIR = ${PREFIX}/build

SED ?= $(shell which sed)
ZIP ?= $(shell which zip)
VER ?= $(shell ${SED} -ne 's/\(.*\)<version>\(.*\)<\/version>/\2/p' ${TYPE}${NAME}.xml)

#do not compress files
ZIPNONE = .png:.jpg
#do not include files
ZIPEXCL = \*.DS_Store \*.git \*.gitignore \*project

BASE_FILES = mod_doyandexmetrika.php\
	mod_doyandexmetrika.xml\
	README\
	LICENSE.TXT\
	index.html\
	helper.php\
	script.php\
	media/\
	tmpl/\
	language/

DIST = ${DIST_DIR}/${TYPE}${NAME}-v${VER}.zip

all: clean module

module: ${DIST}
	@@echo ${DIST} 'build complete.'

${DIST_DIR}:
	@@mkdir -p ${DIST_DIR}

${DIST}: ${DIST_DIR}
	@@echo "Building" ${DIST}
	@@${ZIP} -rn ${ZIPNONE} ${DIST} ${BASE_FILES} -x ${ZIPEXCL}

clean:
	@@echo "Removing distribution directory:" ${DIST_DIR}
	@@rm -rf ${DIST_DIR}

.PHONY: all module clean
