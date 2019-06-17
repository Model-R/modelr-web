#############################
####    Script modelR   ####
############################

# Carregando pacotes
require(ModelR)
require(raster)
require(vegan)
require(psych)

args <- commandArgs(TRUE)
id <- args[1]
rasterCSVPath <- args[2]
ocorrenciasCSVPath <- args[3]
rasterCSVPath
ocorrenciasCSVPath

coordenadas <- read.table(ocorrenciasCSVPath, sep = ';', header = T);
rasters <- read.table(rasterCSVPath, sep = ';', header = F, as.is = T);

rasters <- paste0('../../../../../',rasters)
stack_rasters <- stack(rasters)

coordenadas
#verificando a correlação
pontos = dismo::randomPoints(stack_rasters, 1000)
cat('1')
absvals = raster::extract(stack_rasters, pontos)
cat('2')
sdmdata = data.frame(cbind(absvals))
cat('3')
tabela.cor = round(cor(sdmdata), 2)
cat('4')
write.table(tabela.cor, 'correlaco.csv', sep=";")

cat('passou')

panel.reg <- function(x, y, bg = NA, cex = 1, col.regres = "red", ...) {
  points(x, y, cex = cex)
  abline(stats::lm(y ~ x), col = col.regres, ...)
}

panel.cor <- function(x, y, digits = 2, prefix = "", ...) {
  usr <- par("usr")
  on.exit(par(usr))
  par(usr = c(0, 1, 0, 1))
  r <- cor(x, y)
  txt <- format(c(r, 0.123456789), digits = digits)[1]
  txt <- paste0(prefix, txt)
  text(0.5, 0.5, txt, cex = 1.5)
}

panel.hist <- function(x, ...) {
  usr <- par("usr")
  on.exit(par(usr))
  par(usr = c(usr[1:2], 0, 1.5))
  h <- hist(x, plot = FALSE)
  breaks <- h$breaks
  nB <- length(breaks)
  y <- h$counts
  y <- y / max(y)
  rect(breaks[-nB], 0, breaks[-1], y, col = "gray", ...)
}

png(paste0('/temp/',id,'/correlacao-images.png'))

pairs(sdmdata,
	cex = 0.1,
	fig = TRUE,
	lower.panel = panel.reg,
	diag.panel = panel.hist,
	upper.panel = panel.cor
)
dev.off()