# @version	$Id$
# @package	Joomla.Site
# @subpackage  mod_doyandexmetrika
# @author	Sergey Donin
# @author mail	dostrog@gmail.com

PREFIX = .
DIST_DIR = ${PREFIX}/dist

ZIP ?= `which zip`
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
	images/80x15.png\
	images/80x31.png\
	images/88x31.png\
	images/gray_arrow.png\
	images/violet_arrow.png\
	images/index.html\
	tmpl/default.php\
	tmpl/index.html\
	language/

YM = ${DIST_DIR}/mod_doyandexmetrika.zip

all: clean module

module: ${YM}
	@@echo "mod_doyandexmetrika build complete."

${DIST_DIR}:
	@@mkdir -p ${DIST_DIR}

${YM}: ${DIST_DIR}
	@@echo "Building" ${YM}
	@@${ZIP} -rn ${ZIPNONE} ${YM} ${BASE_FILES} -x ${ZIPEXCL}

clean:
	@@echo "Removing distribution directory:" ${DIST_DIR}
	@@rm -rf ${DIST_DIR}

.PHONY: all module clean
