debug:
	ncc build --config="debug"

release:
	ncc build --config="release"

install:
	ncc package install --package="build/release/net.nosial.rtex.ncc" --skip-dependencies --reinstall -y

install-debug:
	ncc package install --package="build/debug/net.nosial.rtex.ncc" --skip-dependencies --reinstall -y

uninstall:
	ncc package uninstall -y --package="net.nosial.rtex"