#############################
####    Script modelR   ####
############################

# Carregando pacotes
require(raster)
require(dismo)

args <- commandArgs(TRUE)
id <- args[1]
rasterCSVPath <- args[2]

if(getwd() != "/var/www/html/rafael/modelr"){
	baseUrl <- '../'
} else {
	baseUrl <- ''
}

rasters <- read.table(rasterCSVPath, sep = ';', header = F, as.is = T);
rasters <- paste0(baseUrl,'../../../../../',rasters)
stack_rasters <- stack(rasters)

abio = stack_rasters
plot = TRUE
method = "pearson"
rep = 1000

if(class(abio)=="RasterStack"|class(abio)=="RasterLayer"){
  backg <- randomPoints(abio, n = rep)
  colnames(backg) = c("long", "lat")
  backvalues = extract(abio, backg)
}else(backvalues=abio)


if (plot == T) {
	panel.cor <- function(x, y, digits = 2, prefix = "", ...) {
		usr <- par("usr")
		on.exit(par(usr))
		par(usr = c(0, 1, 0, 1))
		r <- cor(x, y, method = method)
		txt <- format(c(r, 0.123456789), digits = digits)[1]
		txt <- paste0(prefix, txt)
		text(0.5, 0.5, txt, cex = 1.2)
	}

	panel.hist <- function(x, ...){
		usr <- par("usr"); on.exit(par(usr))
		par(usr = c(usr[1:2], 0, 1.5) )
		h <- hist(x, plot = FALSE)
		breaks <- h$breaks; nB <- length(breaks)
		y <- h$counts; y <- y/max(y)
		rect(breaks[-nB], 0, breaks[-1], y, col = "gray", ...)
	}
	
	png(file = paste0(baseUrl,"temp/", id, "/correlation-",id,".png"), bg = "transparent")
	pairs(backvalues, lower.panel = panel.smooth, diag.panel= panel.hist, upper.panel = panel.cor)
	dev.off()
}
#round(cor(backvalues, method = method), 2)
paste0(baseUrl,"temp/", id, "/correlation-",id,".png")